<template>
    <div :class="(level === 1 ? 'px-6 py-4' : 'py-4') + ' flex'">
        <img
            :class="(level === 1 ? 'w-10 h-10' : 'w-6 h-6') + ' rounded'"
            :src="comment.author.avatar"
            :alt="comment.author.name"
        >
        <div class="flex-1 ml-4">
            <div class="text-sm leading-none mb-2">
                <span class="font-semibold">{{ `@${comment.author.name}` }}</span>
                <span class="text-gray-600 mx-1">•</span>
                <span class="text-gray-600">{{ comment.created_at | fromNow }}</span>
                <template v-if="comment.isEdited">
                    <span class="text-gray-600 mx-1">•</span>
                    <span class="text-gray-600">edited</span>
                </template>
            </div>
            <div v-if="state === 'editing'">
                <comment-edit-form @saved="updated" @cancelled="state = 'idle'" :comment="comment"></comment-edit-form>
            </div>
            <div v-if="state !== 'editing'">
                <img v-if="comment.media" :src="comment.media" class="max-w-full rounded mb-2" style="max-height: 400px;">
                <div v-html="comment.html"></div>
                <div class="text-sm mt-2">
                    <button @click="state = 'replying'" class="text-gray-600 hover:text-gray-400 focus:outline-none">Reply</button>
                    <template v-if="comment.can.update">
                        <span class="text-gray-600 mx-1">•</span>
                        <button @click="state = 'editing'" class="text-gray-600 hover:text-gray-400 focus:outline-none">Edit</button>
                    </template>
                    <template v-if="comment.can.delete">
                        <span class="text-gray-600 mx-1">•</span>
                        <button @click="deleted" class="text-gray-600 hover:text-gray-400 focus:outline-none">Delete</button>
                    </template>
                </div>
            </div>
            <div v-if="state === 'replying'" class="mt-4">
                <reply-create-form
                    @saved="replied"
                    @cancelled="state = 'idle'"
                    :mention="replyTo.author.name"
                    :comment="replyTo"
                />
            </div>
            <slot></slot>
        </div>
    </div>
</template>

<script>
import days from 'dayjs'
import axios from 'axios'
import ReplyCreateForm from './ReplyCreateForm'
import CommentEditForm from './CommentEditForm'

export default {
    props: {
        comment: {
            type: Object,
            required: true
        },

        replyTo: {
            type: Object,
            required: true
        },

        level: {
            type: Number,
            default: 1,
        },
    },

    components: {
        ReplyCreateForm,
        CommentEditForm,
    },

    filters: {
        fromNow: function (value) {
            return dayjs(value).fromNow(true)
        }
    },

    data () {
        return {
            state: 'idle'
        }
    },

    methods: {
        updated (comment) {
            this.$emit('updated', comment)
            this.state = 'idle'
        },

        deleted () {
            if (window.confirm('Are you sure you want to delete this?')) {
                axios.delete(`/comments/${this.comment.id}`)
                    .then(response => this.$emit('deleted', response.data))
                    .catch(error => console.log(error))
            }
        },

        replied (reply) {
            this.$emit('replied', reply)
            this.state = 'idle'
        }
    }
}
</script>

<style>

</style>

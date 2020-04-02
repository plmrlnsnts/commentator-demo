<template>
    <div class="flex py-4">
        <img class="h-6 w-6 rounded-full" :src="reply.author.avatar" alt="">
        <div class="flex-1 ml-4">
            <div class="text-sm leading-none mb-2">
                <span class="font-semibold">{{ `@${reply.author.name}` }}</span>
                <span class="text-gray-600 mx-1">•</span>
                <span class="text-gray-600">{{ reply.created_at | fromNow }}</span>
                <template v-if="reply.isEdited">
                    <span class="text-gray-600 mx-1">•</span>
                    <span class="text-gray-600">edited</span>
                </template>
            </div>
            <div v-if="state === 'editing'">
                <comment-edit-form @saved="updated($event)" @cancelled="state = 'idle'" :comment="reply"></comment-edit-form>
            </div>
            <div v-if="state !== 'editing'">
                <img v-if="reply.media" :src="reply.media" class="max-w-full rounded border border-gray-200 mb-2" style="max-height: 400px;">
                <div v-html="reply.html"></div>
                <div class="text-sm mt-2">
                    <button @click="state = 'replying'" class="text-gray-600 hover:text-gray-800 focus:outline-none">Reply</button>
                    <template v-if="reply.can.update">
                        <span class="text-gray-600 mx-1">•</span>
                        <button @click="state = 'editing'" class="text-gray-600 hover:text-gray-800 focus:outline-none">Edit</button>
                    </template>
                    <template v-if="reply.can.delete">
                        <span class="text-gray-600 mx-1">•</span>
                        <button @click="deleted" class="text-gray-600 hover:text-gray-800 focus:outline-none">Delete</button>
                    </template>
                </div>
            </div>
            <div v-if="state === 'replying'" class="mt-4">
                <reply-create-form
                    @saved="replied($event)"
                    @cancelled="state = 'idle'"
                    :mention="reply.author.name"
                    :comment="comment" />
            </div>
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
        reply: {
            type: Object,
            required: true
        },
        comment: {
            type: Object,
            required: true,
        }
    },

    components: {
        ReplyCreateForm,
        CommentEditForm,
    },

    data () {
        return {
            state: 'idle'
        }
    },

    filters: {
        fromNow: function (value) {
            return dayjs(value).fromNow(true)
        }
    },

    methods: {
        updated (comment) {
            this.$emit('updated', comment)
            this.state = 'idle'
        },

        replied (reply) {
            this.state = 'idle'
            this.$emit('replied', reply)
        },

        deleted () {
            if (window.confirm('Are you sure you want to delete this?')) {
                axios.delete(`/comments/${this.reply.id}`)
                    .then(response => this.$emit('deleted', response.data))
                    .catch(error => console.log(error))
            }
        }
    }
}
</script>

<template>
    <div class="flex px-6 py-4">
        <img class="h-10 w-10 rounded-full" :src="comment.author.avatar" alt="">
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
                <comment-edit-form @saved="updated($event)" @cancelled="state = 'idle'" :comment="comment"></comment-edit-form>
            </div>
            <div v-if="state !== 'editing'">
                 <img v-if="comment.media" :src="comment.media" class="max-w-full rounded border border-gray-200 mb-2" style="max-height: 400px;">
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
                    @saved="replied($event)"
                    @cancelled="state = 'idle'"
                    :mention="comment.author.name"
                    :comment="comment" />
            </div>
            <reply-list ref="replyList" :comment="comment"></reply-list>
        </div>
    </div>
</template>

<script>
import days from 'dayjs'
import axios from 'axios'
import ReplyList from './ReplyList'
import ReplyCreateForm from './ReplyCreateForm'
import CommentEditForm from './CommentEditForm'

export default {
    props: {
        comment: {
            type: Object,
            required: true
        }
    },

    components: {
        ReplyList,
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
            this.$refs.replyList.total++

            if (! this.$refs.replyList.isCollapsed) {
                this.$refs.replyList.isCollapsed = true
            } else {
                this.$refs.replyList.replies.unshift(reply)
            }
        },

        deleted () {
            if (window.confirm('Are you sure you want to delete this?')) {
                axios.delete(`/comments/${this.comment.id}`)
                    .then(response => this.$emit('deleted', response.data))
                    .catch(error => console.log(error))
            }
        }
    }
}
</script>

<template>
    <div class="flex p-6">
        <img class="h-10 w-10 rounded" :src="user.avatar" alt="">
        <div class="flex-1 ml-4">
            <comment-form ref="commentForm" @submitted="submitted" />
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import CommentForm from './CommentForm'

export default {
    props: {
        user: {
            type: Object,
            required: true
        },
        commentable: {
            type: Object,
            required: true,
        }
    },

    components: {
        CommentForm,
    },

    methods: {
        submitted (form) {
            axios.post('/comments', { ...form, commentableKey: this.commentable.commentableKey })
                .then(response => {
                    this.$emit('saved', response.data)
                    this.$refs.commentForm.reset()
                })
                .catch(error => console.log(error))
        },
    }
}
</script>

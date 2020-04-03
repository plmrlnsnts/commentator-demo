<template>
    <comment-form
        :comment="comment"
        :placeholder="comment.body"
        @submitted="submitted"
        @cancelled="$emit('cancelled')"
    />
</template>

<script>
import axios from 'axios'
import CommentForm from './CommentForm'

export default {
    props: {
        comment: {
            type: Object,
            required: true,
        }
    },

    components: {
        CommentForm
    },

    methods: {
        submitted (form) {
            axios.patch(`/comments/${this.comment.id}`, form)
                .then(response => this.$emit('saved', response.data))
                .catch(error => console.log(error))
        },
    }
}
</script>

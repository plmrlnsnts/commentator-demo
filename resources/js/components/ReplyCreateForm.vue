<template>
    <comment-form
        :comment="{ body: `@${mention} ` }"
        :placeholder="`Reply to @${mention}`"
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
        },
        mention: {
            type: String,
            required: true,
        }
    },

    components: {
        CommentForm,
    },

    methods: {
        submitted (form) {
            axios.post(`/comments/${this.comment.id}/replies`, form)
                .then(response => this.$emit('saved', response.data))
                .catch(error => console.log(error))
        },
    }
}
</script>

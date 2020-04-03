<template>
    <comment
        :level="2"
        :comment="reply"
        :reply-to="comment"
        @updated="$emit('updated', $event)"
        @deleted="$emit('deleted', $event)"
        @replied="$emit('replied', $event)"
    />
</template>

<script>
import Comment from './Comment'

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
        Comment,
    },
}
</script>

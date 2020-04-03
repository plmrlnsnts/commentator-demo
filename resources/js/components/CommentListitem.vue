<template>
    <comment
        :comment="comment"
        :reply-to="comment"
        @updated="$emit('updated', $event)"
        @deleted="$emit('deleted', $event)"
        @replied="replied"
    >
        <reply-list
            ref="replyList"
            :comment="comment"
        />
    </comment>
</template>

<script>
import Comment from './Comment'
import ReplyList from './ReplyList'

export default {
    props: {
        comment: {
            type: Object,
            required: true
        }
    },

    components: {
        Comment,
        ReplyList,
    },

    methods: {
        replied (reply) {
            this.$refs.replyList.total++

            if (! this.$refs.replyList.isCollapsed) {
                this.$refs.replyList.isCollapsed = true
            } else {
                this.$refs.replyList.replies.unshift(reply)
            }
        }
    }
}
</script>

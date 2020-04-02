<template>
    <div>
        <a
            href="#"
            v-show="total"
            @click.prevent="isCollapsed = !isCollapsed"
            class="inline-flex items-center font-semibold text-sm mt-4">
            <span class="inline-flex items-center" v-if="isCollapsed">
                <svg class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                <span class="ml-2">Hide {{ total | pluralize('reply', 'replies') }}</span>
            </span>
            <span class="inline-flex items-center" v-else>
                <svg class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="ml-2">View {{ total | pluralize('reply', 'replies') }}</span>
            </span>
        </a>

        <div v-show="isCollapsed">
            <transition-group
                tag="div"
                enter-active-class="transition duration-300 ease-in-out"
                leave-active-class="transition duration-300 ease-in-out"
                enter-class="opacity-0"
                enter-to-class="opacity-100"
                leave-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <reply-list-item
                    v-for="(reply, i) in replies"
                    :key="reply.id"
                    :reply="reply"
                    :comment="comment"
                    @replied="prepend($event)"
                    @updated="replies.splice(i, 1, $event)"
                    @deleted="replies.splice(i, 1); total--;"
                    />
            </transition-group>

            <a
                href="#"
                v-show="hasNext"
                @click.prevent="fetch"
                class="inline-block font-semibold text-sm mt-2">
                Show more replies...
            </a>
        </div>

        <transition
            enter-active-class="transition duration-300 ease-in-out"
            enter-class="opacity-0"
            enter-to-class="opacity-100"
        >
            <p v-show="state === 'loading'" class="font-medium mt-4">Loading...</p>
        </transition>
    </div>
</template>

<script>
import ReplyListItem from './ReplyListItem'

export default {
    props: {
        comment: {
            type: Object,
            required: true
        }
    },

    components: {
        ReplyListItem,
    },

    filters: {
        pluralize: function (value, singular, plural) {
            return value === 1
                ? `${value} ${singular}`
                : `${value} ${plural}`
        }
    },

    data () {
        return {
            page: 1,
            replies: [],
            hasNext: false,
            isCollapsed: false,
            hasCollapsed: false,
            total: this.comment.replies_count,
            state: 'idle',
        }
    },

    methods: {
        fetch () {
            this.state = 'loading'
            axios.get(`/comments/${this.comment.id}/replies`, {
                params: {
                    page: this.page,
                    sort: 'latest',
                    perPage: 10,
                }
            }).then(response => {
                response.data.data
                    .filter(reply => ! this.hasDuplicate(reply))
                    .forEach(reply => this.replies.push(reply))
                this.hasNext = !! response.data.next_page_url;
                this.state = 'idle'
                this.page++
            })
        },

        hasDuplicate (reply) {
            return this.replies.find(r => r.id === reply.id)
        },

        prepend (reply) {
            this.total++
            this.replies.unshift(reply)

            this.$nextTick(() => (
                document.getElementById(`comment-${reply.parent_id}`)
                    .scrollIntoView({ behavior: 'smooth' })
            ))
        }
    },

    watch: {
        isCollapsed: function (value) {
            if (value && ! this.hasCollapsed) {
                this.hasCollapsed = true
                this.fetch()
            }
        }
    }
}
</script>

<style>

</style>

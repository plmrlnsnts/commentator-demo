<template>
    <div>
        <comment-create-form
            v-if="user"
            v-bind="{ commentable, user }"
            @saved="comments.unshift($event)"
        />

        <transition-group
            tag="div"
            enter-active-class="transition duration-300 ease-out"
            leave-active-class="transition duration-300 ease-in"
            enter-class="opacity-0"
            enter-to-class="opacity-100"
            leave-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <comment-list-item
                v-for="(comment, i) in comments"
                :key="comment.id"
                :comment="comment"
                :id="`comment-${comment.id}`"
                @updated="comments.splice(i, 1, $event)"
                @deleted="comments.splice(i, 1)"
            />
        </transition-group>

        <transition
            enter-active-class="transition duration-300 ease-in-out"
            leave-active-class="transition duration-100 ease-in-out"
            enter-class="opacity-0"
            enter-to-class="opacity-100"
            leave-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <p v-show="state === 'loading'" class="font-medium px-6 mt-4">Loading...</p>
        </transition>
    </div>
</template>

<script>
import _ from 'lodash'
import axios from 'axios'
import CommentListItem from './CommentListItem'
import CommentCreateForm from './CommentCreateForm'

export default {
    props: {
        user: {
            type: Object,
        },
        commentable: {
            type: Object,
            required: true,
        }
    },

    components: {
        CommentListItem,
        CommentCreateForm
    },

    data () {
        return {
            page: 1,
            comments: [],
            hasNext: false,
            state: 'idle',
        }
    },

    mounted () {
        this.fetch()

        window.addEventListener('scroll', _.debounce(() => {
            if (
                (window.innerHeight + window.pageYOffset) <
                (document.body.offsetHeight - (document.body.offsetHeight / 3))) {
               return
            }

            if (this.state === 'loading') {
                return
            }

            if (! this.hasNext) {
                return
            }

            this.fetch()
        }, 300));
    },

    methods: {
        fetch () {
            this.state = 'loading'
            axios.get(`/comments`, {
                params: {
                    commentableKey: this.commentable.commentableKey,
                    page: this.page,
                    sort: 'latest',
                    perPage: 10,
                }
            }).then(response => {
                response.data.data.forEach(c => this.comments.push(c))
                this.hasNext = !! response.data.next_page_url;
                this.state = 'idle'
                this.page++
            })
        },
    }
}
</script>

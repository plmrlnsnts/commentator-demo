<template>
    <form @submit.prevent="submit" class="rounded bg-gray-900">
        <div v-show="form.media" class="px-4 pt-3 inline-block relative">
            <img :src="form.media" class="max-w-full rounded" style="max-height: 400px;">
            <button @click.prevent="form.media = null" class="absolute top-0 right-0 mt-5 mr-6 w-6 h-6 rounded-full inline-flex items-center justify-center bg-red-500 text-white">
                <svg fill="currentColor" viewBox="0 0 20 20" class="w-4 h-4"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            </button>
        </div>

        <textarea
            ref="inputBody"
            v-model="form.body"
            :placeholder="comment.body"
            class="block w-full bg-transparent rounded appearance-none leading-tight px-4 py-3 resize-none focus:outline-none"
            autocomplete="off"
            rows="4"
            required
        ></textarea>

        <div class="flex items-end justify-between px-4 py-3">
            <upload
                v-slot="{ toggle }"
                @uploading="uploading = true"
                @uploaded="form.media = $event; uploading = false"
            >
                <button @click.prevent="toggle" class="text-gray-400 hover:text-gray-100 focus:outline-none">
                    <span v-if="uploading" class="text-sm text-gray-400">Uploading ...</span>
                    <svg v-if="! uploading" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </button>
            </upload>
            <div>
                <button
                    class="px-3 py-2 rounded text-sm font-medium focus:outline-none"
                    @click.prevent="$emit('cancelled')"
                    type="button"
                >Cancel</button>
                <button
                    class="px-3 py-2 rounded bg-gray-800 text-white text-sm font-medium focus:outline-none focus:shadow-outline"
                    :class="{ 'opacity-50': disabled }"
                    :disabled="disabled"
                    type="submit"
                >Post</button>
            </div>
        </div>
    </form>
</template>

<script>
import axios from 'axios'
import CommentFormMixin from './CommentFormMixin'

export default {
    props: {
        comment: {
            type: Object,
            required: true,
        }
    },

    mixins: [CommentFormMixin],

    data () {
        return {
            form: {
                body: this.comment.body,
                media: this.comment.media,
            }
        }
    },

    methods: {
        submit () {
            axios.patch(`/comments/${this.comment.id}`, this.form)
                .then(response => this.save(response.data))
                .catch(error => console.log(error))
        },
    }
}
</script>

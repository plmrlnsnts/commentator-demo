import Upload from './Upload'

export default {
    components: {
        Upload,
    },

    data () {
        return {
            uploading: false,
            form: {
                body: null,
                media: null,
            },
        }
    },

    mounted () {
        this.$watch('form.body', function () {
            this.$refs.inputBody.style.height = ''
            this.$refs.inputBody.style.height = `${this.$refs.inputBody.scrollHeight}px`
        })
    },

    computed: {
        disabled () {
            if (this.uploading) {
                return true
            }

            if (this.form.body) {
                return false
            }

            if (this.form.media) {
                return false
            }

            return true
        }
    },

    methods: {
        reset () {
            this.form.body = null
            this.form.media = null
        },

        save (comment) {
            this.$emit('saved', comment)
            this.reset()
        }
    }
}

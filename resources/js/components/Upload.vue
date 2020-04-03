<template>
    <span>
        <input
            ref="file"
            type="file"
            class="hidden"
            accept="image/*"
            @change="upload"
        />

        <slot v-bind="{ toggle }"></slot>
    </span>
</template>

<script>
import axios from 'axios'

export default {
    methods: {
        toggle () {
            this.$refs.file.click()
        },

        upload (event) {
            if (! event.target.files.length) {
                return
            }

            this.$emit('uploading')

            axios.post('/upload', this.formData(event.target.files[0]))
                .then(response => this.$emit('uploaded', response.data.path))
                .catch(error => console.log(error))
        },

        formData (file) {
            let formData = new FormData;

            formData.append('file', file)

            return formData;
        }
    }
}
</script>

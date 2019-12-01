<template>
    <input type="file"
           class="custom-file-input"
           accept="image/*"
           @change="onChange"
    >
</template>

<script>
    export default {
        methods: {
            /**
             * @param e
             * @returns {boolean}
             */
            onChange(e) {
                if (!e.target.files.length) {
                    return false;
                }

                let file = e.target.files[0];
                let reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload = (e) => {
                    let src = e.target.result;
                    this.$emit('loaded', {src, file});
                };
            },
        },
    };
</script>

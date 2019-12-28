<template>
    <div>
        <input id="trix" type="hidden" :name="name" :value="value"/>
        <trix-editor ref="trix" input="trix"/>
    </div>
</template>

<script>
    import Trix from 'trix';

    export default {
        props: ['name', 'value'],

        mounted() {
            this.$refs.trix.addEventListener('trix-change', (e) => {
                this.$emit('input', e.target.innerHTML);
            });
        },
    };
</script>

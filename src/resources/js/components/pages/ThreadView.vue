<template>

</template>

<script>
    import RepliesList from '../RepliesList.vue';
    import SubscribeBtn from '../SubscribeBtn';

    export default {
        props: ['thread'],
        components: {RepliesList, SubscribeBtn},

        data() {
            return {
                locked: this.thread.locked,
                repliesCount: this.thread.replies_count,
            };
        },
        methods: {
            toggleLock() {
                axios[this.locked ? 'delete' : 'post'](`/threads/${this.thread.slug}/lock`);
                this.locked = !this.locked;
            },
        },
    };
</script>

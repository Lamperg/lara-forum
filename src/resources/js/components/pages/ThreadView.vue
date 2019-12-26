<template>

</template>

<script>
    import axios from 'axios';
    import RepliesList from '../RepliesList.vue';
    import SubscribeBtn from '../SubscribeBtn';

    export default {
        props: ['thread'],
        components: {RepliesList, SubscribeBtn},

        data() {
            return {
                editing: false,
                locked: this.thread.locked,
                repliesCount: this.thread.replies_count,
                form: {
                    title: this.thread.title,
                    body: this.thread.body,
                },
            };
        },
        methods: {
            toggleLock() {
                const url = `/threads/${this.thread.slug}/lock`;

                axios[this.locked ? 'delete' : 'post'](url);
                this.locked = !this.locked;
            },

            update() {
                const url = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;

                axios.patch(url, this.form).then(() => {
                    this.editing = false;
                    flash('Your thread has been updated.');
                });
            },

            cancel() {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body,
                };

                this.editing = false;
            },
        },
    };
</script>

<template>
    <div class="alert alert-success alert-flash"
         :class="`alert-${level}`"
         role="alert"
         v-show="show"
    >
        {{ body }}
    </div>
</template>

<script>
    import eventBus from '../eventBus';

    export default {
        props: ['message'],

        data() {
            return {
                body: this.message,
                show: false,
                level: 'success',
            };
        },

        created() {
            if (this.message) {
                this.flash();
            }

            eventBus.$on('flash-show', data => this.flash(data));
        },

        methods: {
            flash(data) {
                if (data) {
                    this.level = data.level;
                    this.body = data.message;
                }
                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            },
        },
    };
</script>

<style type="text/css">
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>

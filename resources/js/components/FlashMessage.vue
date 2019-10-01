<template>
    <div class="alert alert-success alert-flash" role="alert" v-show="show">
        <strong>Success!</strong> {{ body }}
    </div>
</template>

<script>
  import eventBus from '../eventBus';

  export default {
    props: ['message'],

    data() {
      return {
        body: '',
        show: false
      };
    },

    created() {
      if (this.message) {
        this.flash(this.message);
      }

      eventBus.$on('flash-show', message => this.flash(message));
    },

    methods: {
      flash(message) {
        this.show = true;
        this.body = message;

        this.hide();
      },

      hide() {
        setTimeout(() => {
          this.show = false;
        }, 3000);
      }
    }
  };
</script>

<style type="text/css">
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>

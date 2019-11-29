<template>
    <button :class="classes" @click="toggle">Subscribe</button>
</template>

<script>
  export default {
    props: ['active'],

    data() {
      return {
        isActive: this.active,
      };
    },

    computed: {

      classes() {
        return ['btn', this.isActive ? 'btn-primary' : 'btn-secondary'];
      },

      url() {
        return `${location.pathname}/subscriptions`;
      },
    },
    methods: {
      /**
       * Toggles the current state
       *
       * @returns {*|void}
       */
      toggle() {
        return this.isActive ? this.unsubscribe() : this.subscribe();
      },

      /**
       * Subscribes current user to the thread
       */
      subscribe() {
        axios.post(this.url).then(() => {
          this.isActive = true;
        });
      },

      /**
       * Unsubscribes current user from the thread
       */
      unsubscribe() {
        axios.delete(this.url).then(() => {
          this.isActive = false;
        });
      },
    },
  };
</script>

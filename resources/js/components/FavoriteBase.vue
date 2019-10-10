<template>
    <button :class="classes" @click="toggle">
        <span class="fa fa-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
  export default {
    props: ['reply'],

    data() {
      return {
        isFavorited: this.reply.isFavorited,
        favoritesCount: this.reply.favoritesCount,
      };
    },

    computed: {

      classes() {
        return ['btn', this.isFavorited ? 'btn-primary' : 'btn-secondary'];
      },

      url() {
        return `/replies/${this.reply.id}/favorites`;
      },
    },

    methods: {
      /**
       * Toggles the current state
       *
       * @returns {*|void}
       */
      toggle() {
        return this.isFavorited ? this.unfavorite() : this.favorite();
      },

      /**
       * Favorite action
       */
      favorite() {
        axios.post(this.url).then(() => {
          this.isFavorited = true;
          this.favoritesCount++;
        });
      },

      /**
       * Unfavorite action
       */
      unfavorite() {
        axios.delete(this.url).then(() => {
          this.isFavorited = false;
          this.favoritesCount--;
        });
      },
    },
  };
</script>

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
      /**
       * @returns {[string, string]}
       */
      classes() {
        return ['btn', this.isFavorited ? 'btn-primary' : 'btn-secondary'];
      },

      /**
       * @returns {string}
       */
      url() {
        return `/replies/${this.reply.id}/favorites`;
      },
    },

    methods: {

      toggle() {
        return this.isFavorited ? this.unfavorite() : this.favorite();
      },

      favorite() {
        axios.post(this.url).then(() => {
          this.isFavorited = true;
          this.favoritesCount++;
        });
      },

      unfavorite() {
        axios.delete(this.url).then(() => {
          this.isFavorited = false;
          this.favoritesCount--;
        });
      },
    },
  };
</script>

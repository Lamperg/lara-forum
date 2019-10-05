<template>
    <button :class="classes" @click="toggle">
        <span class="fa fa-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
  export default {
    name: 'FavoriteBase',
    props: ['reply', 'url'],

    data() {
      return {
        isFavorited: this.reply.isFavorited,
        favoritesCount: this.reply.favoritesCount
      };
    },

    computed: {
      classes() {
        return ['btn', this.isFavorited ? 'btn-primary' : 'btn-secondary'];
      }
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
      }
    }
  };
</script>

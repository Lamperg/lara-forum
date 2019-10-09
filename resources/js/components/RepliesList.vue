<template>
    <div>
        <div v-for="(reply, index) in items">
            <reply-view :data="reply" @deleted="remove(index)"></reply-view>
        </div>
    </div>
</template>

<script>
  import ReplyView from './ReplyView';

  export default {
    props: ['data'],
    components: {ReplyView},

    data() {
      return {
        items: this.data,
      };
    },

    methods: {
      /**
       * @param index
       */
      remove(index) {
        this.items.splice(index, 1);

        this.$emit('removed');

        flash('The reply has been deleted');
      },
    },
  };
</script>

<template>
    <div>
        <div v-for="(reply, index) in items">
            <reply-view :data="reply" @deleted="remove(index)"></reply-view>
        </div>

        <new-reply-form :endpoint="endpoint" @created="add"></new-reply-form>
    </div>
</template>

<script>
  import ReplyView from './ReplyView';
  import NewReplyForm from './NewReplyForm';

  export default {
    props: ['data'],
    components: {ReplyView, NewReplyForm},

    data() {
      return {
        items: this.data,
        endpoint: `${location.pathname}/replies`,
      };
    },

    methods: {

      add(reply) {
        this.items.push(reply);
        this.$emit('added');
      },

      remove(index) {
        this.items.splice(index, 1);
        this.$emit('removed');

        flash('The reply has been deleted');
      },
    },
  };
</script>

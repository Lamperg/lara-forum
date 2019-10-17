<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply-view :data="reply" @deleted="remove(index)"></reply-view>
        </div>

        <paginator-base :dataSet="dataSet" @updated="fetch"></paginator-base>

        <new-reply-form @created="add"></new-reply-form>
    </div>
</template>

<script>
  import ReplyView from './ReplyView';
  import NewReplyForm from './NewReplyForm';
  import collection from './mixins/collection';

  export default {
    components: {ReplyView, NewReplyForm},
    mixins: [collection],

    data() {
      return {
        dataSet: false,
      };
    },

    created() {
      this.fetch();
    },

    methods: {
      /**
       * Retrieve an api url
       *
       * @param page
       * @return {string}
       */
      url(page) {
        if (!page) {
          let query = location.search.match(/page=(\d+)/);
          page = query ? query[1] : 1;
        }

        return `${location.pathname}/replies?page=${page}`;
      },

      /**
       * Get the list of replies
       *
       * @param page
       */
      fetch(page) {
        axios.get(this.url(page)).then(this.refresh);
      },

      /**
       * Update hte current data set
       *
       * @param data
       */
      refresh({data}) {
        this.dataSet = data;
        this.items = data.data;

        window.scrollTo(0, 0);
      },
    },
  };
</script>

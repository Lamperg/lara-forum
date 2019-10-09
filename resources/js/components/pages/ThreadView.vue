<template>

</template>

<script>
  import RepliesList from '../RepliesList.vue';

  export default {
    props: ['initialRepliesCount'],
    components: {RepliesList},

    data() {
      return {
        repliesCount: this.initialRepliesCount,
      };
    },
  };
</script>

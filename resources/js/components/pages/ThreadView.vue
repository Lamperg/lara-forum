<template>

</template>

<script>
  import RepliesList from '../RepliesList.vue';
  import SubscribeBtn from '../SubscribeBtn';

  export default {
    props: ['initialRepliesCount'],
    components: {RepliesList, SubscribeBtn},

    data() {
      return {
        repliesCount: this.initialRepliesCount,
      };
    },
  };
</script>

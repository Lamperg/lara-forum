<script>
  export default {
    name: 'ReplyBase',
    props: ['attributes'],

    data() {
      return {
        editing: false,
        body: this.attributes.body
      };
    },

    methods: {
      update() {
        axios.patch(`/replies/${this.attributes.id}`, {
          body: this.body
        }).then(() => {
          this.editing = false;

          flash('The Reply has been updated');
        });
      }
    }
  };
</script>

<style scoped>

</style>

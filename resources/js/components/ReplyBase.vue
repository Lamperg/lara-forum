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

          flash('The reply has been updated');
        });
      },

      destroy() {
        axios.delete(`/replies/${this.attributes.id}`).then(() => {
          $(this.$el).fadeOut(300, () => {
            flash('The reply has been deleted');
          });
        });
      }
    }
  };
</script>

<style scoped>

</style>

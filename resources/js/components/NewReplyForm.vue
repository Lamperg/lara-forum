<template>
    <div>
        <div v-if="signedIn">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for="body">Reply:</label>
                        <textarea class="form-control"
                                  name="body"
                                  id="body"
                                  rows="3"
                                  placeholder="Have something to say?"
                                  required
                                  v-model="body"
                                  @keypress.enter="addReply"
                        ></textarea>
                    </div>

                    <button
                        class="btn btn-primary"
                        @click="addReply"
                    >Post
                    </button>
                </div>
            </div>
        </div>
        <p v-else class="text-center mt-3">
            Please <a href="/login">sign in</a> to participate in this discussion.
        </p>
    </div>
</template>

<script>
  export default {
    props: ['endpoint'],

    data() {
      return {
        body: '',
      };
    },

    computed: {

      /**
       * @returns {boolean}
       */
      signedIn() {
        return !!window.App.signedIn;
      },
    },

    methods: {

      addReply() {
        axios.post(this.endpoint, {body: this.body}).then((response) => {
          this.body = '';
          flash('Your reply has been posted.');
          this.$emit('created', response.data);
        });
      },
    },
  };
</script>

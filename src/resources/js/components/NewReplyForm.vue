<template>
    <div>
        <div v-if="signedIn">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="form-group">
                        <wysiwyg-editor name="body"
                                        ref="trix"
                                        v-model="body"
                                        placeholder="Have something to say?"
                                        :should-clear="completed"
                        />
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
    import 'at.js';
    import 'jquery.caret';

    export default {
        data() {
            return {
                body: '',
                completed: false,
            };
        },

        mounted() {
            $('#body').atwho({
                at: '@',
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON('/api/users', {name: query}, function(userNames) {
                            callback(userNames);
                        });
                    },
                },
            });
        },

        methods: {
            /**
             * Adds a new reply
             */
            addReply() {
                axios.post(`${location.pathname}/replies`, {body: this.body}).
                    then((response) => {
                        this.body = '';
                        this.completed = true;

                        flash('Your reply has been posted.');
                        this.$emit('created', response.data);
                    }).
                    catch(error => {
                        flash(error.response.data, 'danger');
                    });
            },
        },
    };
</script>

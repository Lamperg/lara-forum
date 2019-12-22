<template>
    <div :id="`reply-${id}`" class="card mt-2">
        <div class="card-header" :class="isBest ? 'bg-success' : ''">
            <div class="level">
                <span class="flex">
                    <a :href="`'/profiles/${data.owner.name}`"
                       v-text="data.owner.name">
                    </a> said <span v-text="ago"></span>
                </span>

                <div v-if="signedIn">
                    <favorite-base :reply="data"></favorite-base>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" rows="3" v-model="body"></textarea>
                    <button class="btn btn-primary btn-sm" @click="update">Update</button>
                    <button class="btn btn-link btn-sm" @click="editing=false">Cancel</button>
                </div>
            </div>
            <div v-else v-html="body"></div>
        </div>

        <div class="card-footer level">
            <div v-if="authorize('updateReply', reply)">
                <button class="btn btn-secondary btn-sm mr-2" @click="editing=true">Edit</button>
                <button class="btn btn-danger btn-sm mr-2" @click="destroy">Delete</button>
            </div>

            <button class="btn btn-info btn-sm ml-auto" @click="markBestReply" v-show="!isBest">Best Reply?</button>
        </div>
    </div>
</template>
<script>
    import moment from 'moment';
    import FavoriteBase from './FavoriteBase';
    import eventBus from '../eventBus';

    export default {
        props: ['data'],
        components: {FavoriteBase},

        data() {
            return {
                editing: false,
                id: this.data.id,
                reply: this.data,
                body: this.data.body,
                isBest: this.data.isBest,
            };
        },

        created() {
            eventBus.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow();
            },
        },

        methods: {
            /**
             * Updates the current reply
             */
            update() {
                axios.patch(`/replies/${this.data.id}`, {
                    body: this.body,
                }).then(() => {
                    this.editing = false;
                    flash('The reply has been updated');
                }).catch(error => {
                    flash(error.response.data, 'danger');
                });
            },

            /**
             * Removed the current reply
             */
            destroy() {
                axios.delete(`/replies/${this.data.id}`).then(() => {
                    this.$emit('deleted', this.data.id);
                });
            },

            markBestReply() {
                axios.post(`/replies/${this.reply.id}/best`).then(() => {
                    eventBus.$emit('best-reply-selected', this.reply.id);
                });
            },
        },
    };
</script>

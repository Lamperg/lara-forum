<template>
    <div>
        <div class="level mb-2">
            <img class="img-thumbnail mr-2"
                 :alt="user.name"
                 :src="avatar"
                 width="80"
                 v-show="avatar"
            >

            <h1 v-text="user.name"></h1>
        </div>
        <div class="mb-4">


            <form v-if="canUpdate" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <div class="custom-file">
                        <label class="custom-file-label">
                            Choose an avatar
                            <image-upload name="avatar" @loaded="onLoaded"></image-upload>
                        </label>
                    </div>
                </div>
            </form>


        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import ImageUpload from './ImageUpload';

    export default {
        props: ['user'],
        components: {ImageUpload},

        data() {
            return {
                avatar: this.user.avatar_path,
            };
        },
        computed: {

            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            },
        },
        methods: {
            /**
             * @param avatar
             */
            onLoaded(avatar) {
                this.avatar = avatar.src;
                this.persist(avatar.file);
            },

            /**
             * @param avatar
             */
            persist(avatar) {
                let data = new FormData();
                data.append('avatar', avatar);

                axios.post(`/api/users/${this.user.name}/avatar`, data).
                    then(() => flash('Avatar has been uploaded')).
                    catch(error => flash(error.response.data, 'danger'));
            },
        },
    };
</script>

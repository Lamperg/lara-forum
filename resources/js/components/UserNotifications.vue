<template>
    <div class="dropdown" v-if="notifications.length">
        <a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
            <span class="fa fa-bell"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right">
            <a v-for="notification in notifications"
               class="dropdown-item"
               :href="notification.data.link"
               v-text="notification.data.message"
               @click="markAsRead(notification)"
            ></a>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        notifications: false,
      };
    },

    created() {
      axios.get(this.url).
          then((response) => this.notifications = response.data);
    },

    computed: {
      url() {
        return `/profiles/${window.App.user.name}/notifications`;
      },
    },

    methods: {
      markAsRead(notification) {
        axios.delete(`${this.url}/${notification.id}`);
      },
    },
  };
</script>

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import eventBus from './eventBus';
import InstantSearch from 'vue-instantsearch';
import authorizations from './authorizations';

require('./bootstrap');

window.Vue = require('vue');

/**
 * Authorization mixin for Vue components
 * @returns {boolean}
 * @param params
 */
window.Vue.prototype.authorize = function(...params) {
    if (!window.App.signedIn) {
        return false;
    }
    if (typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
};

window.Vue.prototype.signedIn = !!window.App.signedIn;

window.Vue.use(InstantSearch);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue ->
 * <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0],
// files(key).default));

Vue.component(
    'avatar-form',
    require('./components/AvatarForm.vue').default,
);
Vue.component(
    'paginator-base',
    require('./components/PaginatorBase').default,
);
Vue.component(
    'flash-message',
    require('./components/FlashMessage.vue').default,
);
Vue.component(
    'thread-view',
    require('./components/pages/ThreadView.vue').default,
);
Vue.component(
    'user-notifications',
    require('./components/UserNotifications.vue').default,
);

Vue.component(
    'search-form',
    require('./components/SearchForm.vue').default,
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

/**
 * The flash-message helper
 * @param message
 * @param level
 */
window.flash = function(message, level = 'success') {
    eventBus.$emit('flash-show', {message, level});
};

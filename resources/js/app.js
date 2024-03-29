/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import 'ant-design-vue/dist/antd.css';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('admin-members', require('./components/AdminMembers.vue').default);
Vue.component('admin-games', require('./components/AdminGames.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
let membersApp = document.getElementById("membersApp");
if (typeof(membersApp) !== "undefined" && membersApp !== null) {
    const app = new Vue({
        el: '#membersApp',
        template: '<admin-members></admin-members>'
    });
};

let gamesApp = document.getElementById("gamesApp");
if (typeof(gamesApp) !== "undefined" && gamesApp !== null) {
    const app = new Vue({
        el: '#gamesApp',
        template: '<admin-games></admin-games>'
    });
};

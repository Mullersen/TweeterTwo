require('./app.js');


Vue.component('Like', require('./components/Like.vue').default);
Vue.component('Giphy', require('./components/Giphy.vue').default);
Vue.component('Myretweet', require('./components/Myretweet.vue').default);
Vue.component('Messaging', require('./components/Messaging.vue').default);

const app = new Vue({
    el: '#tweet-vue',
});
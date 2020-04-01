require('./app.js');


Vue.component('Like', require('./components/Like.vue').default);
Vue.component('Giphy', require('./components/Giphy.vue').default);

const app = new Vue({
    el: '#tweet-vue',
});
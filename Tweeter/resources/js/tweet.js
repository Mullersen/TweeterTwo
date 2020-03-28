require('./app.js');


Vue.component('Like', require('./components/Like.vue').default);


const app = new Vue({
    el: '#tweet-like',
});
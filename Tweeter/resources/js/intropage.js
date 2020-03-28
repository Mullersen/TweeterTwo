require('./app');
Vue.component('Root', require('./components/Root.vue').default);
const app = new Vue({
    el: '#welcome-page',
});
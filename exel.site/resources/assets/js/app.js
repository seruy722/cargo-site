require('./bootstrap');

window.Vue = require('vue');
window.VueRouter = require('vue-router').default;
window.VueAxios = require('vue-axios').default;
window.Axios = require('axios').default;
window.JsonExcel = require('vue-json-excel');

Vue.component('downloadExcel', JsonExcel);

let AppLayout = require('./components/App.vue');

const Listposts = Vue.component('Listposts', require('./components/Listposts.vue'));
const Addpost = Vue.component('Addpost', require('./components/Addpost.vue'));
const Deletepost = Vue.component('Deletepost', require('./components/Deletepost.vue'));
const Editpost = Vue.component('Editpost', require('./components/Editpost.vue'));
const Viewpost = Vue.component('Viewpost', require('./components/Viewpost.vue'));




Vue.use(VueRouter, VueAxios, axios);

const routes = [
    {
        name:'Listposts',
        path:'/',
        component:Listposts
    },
    {
        name:'Addpost',
        path:'/add-post',
        component:Addpost
    },
    {
        name:'Deletepost',
        path:'/post-delete',
        component:Deletepost
    },
    {
        name:'Editpost',
        path:'/edit/:id',
        component:Editpost
    },
    {
        name:'Viewpost',
        path:'/view/:id',
        component:Viewpost
    }
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

new Vue(
    Vue.util.extend({
            router
        },
        AppLayout
    )
).$mount('#app');

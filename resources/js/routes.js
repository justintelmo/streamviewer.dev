import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use( VueRouter );

export default new VueRouter({
    routes: [
        {
            path: '/',
            name: 'layout',
            component: Vue.component( 'Layout', require( './pages/Layout.vue' ) ),
            children: [
                {
                    path: '/',
                    name: 'Home',
                    component: Vue.component( 'Home', require('./pages/Home.vue') ),  
                },
                {
                    path: '/streams',
                    name: 'streams',
                    component: Vue.component( 'Streams', require( './pages/Streams.vue' ) )
                },
                {
                    path: '/streams/:id',
                    name: 'stream',
                    component: Vue.component( 'Stream', require( './pages/Stream.vue' ) )
                },
                {
                    path: '/stats/:id/:chatId',
                    name: 'stats',
                    component: Vue.component( 'Stats', require( './pages/Stats.vue' ) )
                }
            ]
        },
        
    ]
})
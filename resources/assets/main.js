
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


//引入所有相关插件插件
require('./plugins');

// /*####  提示插件 ####*/
// import './js/toastr.min.js';
// 路由
import VueRouter from 'vue-router';
import routes from './routes.js';
Vue.use(VueRouter);

const router = new VueRouter({
	routes : routes,
	mode: 'history',
	base: __dirname,
    // linkActiveClass: 'active',
});

router.beforeEach((to, from, next) => {
  	//验证权限

  	if(!store.state.auth){
  		location.href = '/login';
  		return;
  	}
    let strPath = to.path.replace(/\/\d+$/,'');

  	if(to.path != '/' && store.state.permissions.indexOf(strPath) === -1){

  		setTimeout(function(){
  			toastr.error('您没有访问权限!');
  		},0);
    	next(false);
  	}else {
        // 储存当前选中siderbar
        if (to.meta.parent) {
            store.state.modular.parent = to.meta.parent;
            store.state.modular.child = to.path;
        }
        next();
    }
});
//axios 重写
import util from './util.js';
Vue.use(util);


//状态管理
import store from './store/index.js';

//app 挂载
import App from './components/App.vue';
const app = new Vue(Vue.util.extend({ router , store },App)).$mount('#app');






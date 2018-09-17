
import Vue from 'vue';
import Vuex from 'vuex';
import * as actions from './actions.js';
import * as mutations from './mutations.js';
Vue.use(Vuex);

const state  = {
	auth : window.auth,
	permissions: window.permissions,
	menuTree: window.menuTree,
	modular: {
		parent: '',
		child: ''
	},
	nodeModalData : {},
    checkNodes:[],
};

export default new Vuex.Store({
	state,
	actions,
	mutations,
});
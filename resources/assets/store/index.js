
import Vue from 'vue';
import Vuex from 'vuex';
import * as actions from './actions.js';
import * as mutations from './mutations.js';
Vue.use(Vuex);

const state  = {
	auth : window.auth,
	permissions: window.permissions,
	menuTree: window.menuTree,
	nodeEdit : {
		node_id: null,
        p_title : '根节点',
        title: '',
        action:'',
        parent_id: null,
        is_show: 2,
        level: null,
        linecons: '',
        sort: 50,
        modal_show: false,
   	},
    checkNodes:[],
};

export default new Vuex.Store({
	state,
	actions,
	mutations,
});
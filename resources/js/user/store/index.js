import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth'
import common from './modules/common'

Vue.use(Vuex);

const store = new Vuex.Store({
	modules:{
		common,
		auth
	}
});

export default store
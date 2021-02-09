window.Vue = require('vue');

import Axios from "axios";
import App from "./App";
import router from './router'
import store from './store';
import VModal from 'vue-js-modal';
import VueSimpleAlert from "vue-simple-alert";
import i18n from './locales';
import messages from "./configs/messages"

// settings

// vue modal
Vue.use(VModal,
{
  dynamic: true,
  dynamicDefaults: {
    height: 'auto'
  },
});

// vue alert ( like a modal ) - alerts successful or error messagers on load 
Vue.use(VueSimpleAlert);

// turning axios into this.$http - for the usage to be simpler
// $i18n is turned automatically while creating app, just like store 
Vue.prototype.$http = Axios;

// x-csrf token ... should be clear )
Axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const app = new Vue({
  el: '#app',
  render: h => h(App),
  store,
  i18n,
  router
});

Vue.config.productionTip = false

// custom

// turns string date into date value for an input type date
Date.prototype.toDateInputValue = (function() {
  var local = new Date(this);
  local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
  return local.toJSON().slice(0,10);
});

// error or success messages
window.messages=messages;

// creates a fast copy of any object
window.copy=(object)=>{
	return JSON.parse(JSON.stringify(object));
}

// capitalizes any string ( only first letter )
window.capitalize = (s) => {
	let string = s.slice();
	if (typeof string !== 'string') return ''
    return string.charAt(0).toUpperCase() + string.slice(1)
}

// returns you an object without a key  ( deletes a key from an object )
window.objectWithoutKey = (object, key) => {
  const {[key]: deletedKey, ...otherKeys} = object;
  return otherKeys;
}
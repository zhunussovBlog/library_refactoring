import Vue from 'vue'
import Axios from "axios"
import VModal from 'vue-js-modal'
import VueSimpleAlert from "vue-simple-alert"

import App from "./App"
import router from './router'
import i18n from './locales'
import store from './store'

import base from '../configs/base'

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

window.configs=Object.assign({},base);
Vue.config.productionTip = false;

// setting axios defaults
Axios.defaults.baseURL = window.configs.baseURL + window.configs.api
Axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token');
Axios.defaults.headers.common['Content-Type'] = 'application/json';
Axios.defaults.headers.common['Content-Language'] = i18n.locale;

// turning axios into this.$http - for the usage to be simpler
// $i18n is turned automatically while creating app, just like store 
Vue.prototype.$http = Axios;

// custom
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

// turns xml to json
window.xml2json= (xml)=> {
	
	// Create the return object
	var obj = {};

	if (xml.nodeType == 1) { // element
		// do attributes
		if (xml.attributes.length > 0) {
		obj["@attributes"] = {};
			for (var j = 0; j < xml.attributes.length; j++) {
				var attribute = xml.attributes.item(j);
				obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
			}
		}
	} else if (xml.nodeType == 3) { // text
		obj = xml.nodeValue;
	}

	// do children
	if (xml.hasChildNodes()) {
		for(var i = 0; i < xml.childNodes.length; i++) {
			var item = xml.childNodes.item(i);
			var nodeName = item.nodeName;
			if (typeof(obj[nodeName]) == "undefined") {
				obj[nodeName] = xmlToJson(item);
			} else {
				if (typeof(obj[nodeName].push) == "undefined") {
					var old = obj[nodeName];
					obj[nodeName] = [];
					obj[nodeName].push(old);
				}
				obj[nodeName].push(xmlToJson(item));
			}
		}
	}
	return obj;
};

// turns string date into date value for an input type date
Date.prototype.toDateInputValue = (function() {
  var local = new Date(this);
  local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
  return local.toJSON().slice(0,10);
});

new Vue({
  render: h => h(App),
  i18n,
  router,
  store
}).$mount('#app')
var setLocale = {
	methods:{
		setLocale(locale){
			this.$i18n.locale=locale;
			this.$http.defaults.headers.common['Content-Language'] = this.$i18n.locale;
			localStorage.setItem('lang',JSON.stringify(locale));
		}
	}
};
export default setLocale;
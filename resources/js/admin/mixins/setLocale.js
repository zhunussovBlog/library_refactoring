var setLocale = {
	methods:{
		setLocale(locale){
			locale=locale ?? window.configs.default_lang;
			this.$i18n.locale=locale;
			localStorage.setItem('lang',JSON.stringify(locale));
		}
	}
};
export default setLocale;
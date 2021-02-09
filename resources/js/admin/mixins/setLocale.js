var setLocale = {
	methods:{
		setLocale(locale){
			this.$i18n.locale=locale;
			localStorage.setItem('lang',JSON.stringify(locale));
		}
	}
};
export default setLocale;
<template>
	<div class="relative" tabindex="1" @focusout="shown=false">
		<div class="link text-no-wrap" @click="showDropdown()">{{currentLan.toUpperCase()}} &nbsp;<CaretUp class="rotate"/></div>
		<div class="dropdown dropdown-right transition border-radius bg-white shadowed pl-18 color-black" :class="{shown:shown}">
			<div class="link border-bottom" v-for="(locale,index) in languages" :key="index" @click="lanOnClick(locale)">{{locale.toUpperCase()}}</div>
		</div>
	</div>
</template>
<script type="text/javascript">
// icon
import CaretUp from '../../../assets/icons/CaretUp'
// mixins 
import setLocale from '../../../mixins/setLocale'
import {goTo} from '../../../mixins/goTo'

export default{
	mixins:[setLocale,goTo],
	components:{CaretUp},
	data(){
		return{
			currentLan:this.$i18n.locale ?? 'en',
			languages:['en','ru','kz'],
			shown:false
		}
	},
	methods:{
		lanOnClick(locale){
			this.setLocale(locale);
			this.currentLan=locale;
			this.shown=false;
			// this.$store.dispatch('emptyResults');
			// this.goTo('home');
		},
		showDropdown(){
			this.shown=!this.shown;
		}
	}
}	
</script>
<style scoped>
.shown{
	max-height: 11.25em;
}
.link{
	padding:1em 0;
}
</style>
<template>
	<div class="mt-10 toggleParent dropdown dropdown-left transition border-radius bg-white color-black shadowed pl-18" :class="{shown:show}">
		<router-link :to="link.name" v-for="(link,index) in links" :key="index" class="link" :class="{'color-orange':link.name==$route.name}">{{$t(link.name)}}</router-link>
		<div class="link" @click="goToSDU()">{{$t('about')}}</div>
		<div class="link"  @click="showLogin"> {{logged ? $t('logout') : $t('login')}} </div>
	</div>
</template>
<script type="text/javascript">
// mixins
import {goTo}from '../../../mixins/goTo'
import links from '../../../mixins/links'
import setLocale from '../../../mixins/setLocale'

// components
import login from "./Login"

export default{
	props:{
		show:Boolean,
		close:Function,
		complementaryLinks:Array
	},
	components:{login},
	mixins:[links,goTo,setLocale],
	computed:{
		logged(){
			return this.$store.getters.logged;
		},
		backgrounded(){
			return this.$route.meta.backgrounded;
		}
	},
	methods:{
		goToSDU(){
			window.open("https://sdu.edu.kz/library-new/", '_blank');
		},
		showLogin(){
			if(this.logged){
				this.$store.commit('setLoading',true);
				this.$http.get('auth/logout').then(response=>{
					this.$store.commit('setLoading',false);
					this.$fire({
						title:this.$t('auth_out'),
						text:this.$t("success"),
						type:"success",
						timer:1700
					});;
					this.$store.commit('setUser',{});
					this.close();
				}).catch(error=>{
					this.$store.commit('setLoading',false);
					this.$fire({
						title:this.$t('auth_out'),
						text:error.response.data.message ?? error.message ?? this.$t('error'),
						type:"error",
					});;
					this.close();
				});
				this.goTo('home');
			}
			else{
				this.$modal.show(login,{},{
					height:'auto',
					width:'300px',
					classes:['bigger-border-radius'],
					styles:'padding:0.9375em;',
					shiftY:0.3
				},{});
			}
		},
	}
}
</script>
<style scoped>
.shown{
	max-height: 23em;
}
.link{
	padding:1em 0;
	display: block;
}
</style>
<template>
	<div tabindex="0" class="relative" 	@focusout="active=false">
		<div class="align-items-center link" :class="{'color-orange':active}" @click="active=!active">
			<UserCircle class="icon color-orange" />
			&nbsp;&nbsp;
			<div>
				{{user.name}} 
			</div>
			&nbsp;&nbsp;
			<CaretUp class="rotate" />
		</div>
		<div class="dropdown dropdown-right transition border-radius bg-white color-black shadowed pl-18" :class="{shown:active}">
			<!-- this part is depricated for now -->
			<div class="link border-bottom" v-for="(link,index) in links" :key="index" @click="link.method()" v-if="link.visible">{{$t(link.name)}}</div>
			<div class="link color-orange" @click="logout()">{{$t('logout')}}</div>
		</div>
	</div>
</template>
<script type="text/javascript">
// identication in sublime text 3
import UserCircle from '../../../assets/icons/UserCircle'
import CaretUp from '../../../assets/icons/CaretUp'

// mixins
import {goTo} from '../../../mixins/goTo'
export default{
	mixins:[goTo],
	components:{UserCircle,CaretUp},
	computed:{
		user(){
			return this.$store.getters.user;
		}
	},
	data(){
		return{
			active:false,
			links:[
			{
				name:'profile',
				method:this.goToProfile,
				visible:false
			},
			{
				name:'lib_office',
				method:this.goToAdmin,
				visible:this.$store.state.user.is_admin
			},
			]
		}
	},
	methods:{
		close(){
			setInterval(this.active=false,200);
		},
		goToAdmin(){
			window.location.replace('/admin');
			this.close();
		},
		goToProfile(){
			this.goTo('profile');
			this.close();
		},
		logout(){
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
	}
}
</script>
<style scoped>
.shown{
	max-height: 15em;
}
.link{
	padding:1em 0;
}
.icon{
	font-size: 1.5em;
}
</style>
<template>
	<div class="position-relative" tabindex="1" @focusout="shown=false">
		<div class="d-flex align-items-center" @click="showDropdown()">
			<span class="regIcon">
				<RegUser/>
				&nbsp;
			</span>
			<span class="link">
				{{user.name}} {{user.surname}}
				&nbsp;
				<CaretUp class="rotate"/>
			</span>
		</div>
		<div class="dropdown dropdown-right transition rounded-lg bg-white shadow-sm pl-3" :class="{shown:shown}">
			<div class="link" v-for="(link,index) in links" :key="index" @click="link.method">{{$t(link.name)}}</div>
		</div>
	</div>
</template>
<script type="text/javascript">
// icons
import RegUser from '../../../assets/icons/RegUser'
import CaretUp from '../../../assets/icons/CaretUp'

import {message_error} from '../../../mixins/messages'
export default{
	mixins:[message_error],
	components:{RegUser,CaretUp},
	computed:{
		user(){
			return this.$store.getters.user
		}
	},
	data(){
		return{
			shown:false,
			links:[
			{name:'logout',method:this.logout}
			]
		}
	},
	methods:{
		logout(){
			this.$http.get('logout').then(response=>{
				this.$store.commit('setUser',{});
				localStorage.removeItem('access_token')
				window.location.replace('/');
			}).catch(error=>{
				this.message_error('logout',error);
			});
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
.regIcon{
	font-size: 1.4em;
}
</style>
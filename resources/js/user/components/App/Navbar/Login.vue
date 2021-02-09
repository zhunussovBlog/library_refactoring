<template>
	<div class="parent">
		<div class="title">{{$t('login')}}</div>
		<div class="color-gray mt-10">* {{$t('portal_credentials')}}</div>
		<form class="inputs" @submit.prevent="login">
			<input type="text" class="middle-round" name="login" v-model="user.login" autocomplete="off" :placeholder="$t('login_username')">		
			<input type="password" class="middle-round" name="password" v-model="user.password" autocomplete="off" :placeholder="$t('login_password')">		
			<button type="submit">{{$t('login')}}</button>
		</form>
	</div>
</template>
<script type="text/javascript">
//sublime text 3
export default{
	data(){
		return{
			user:{
				login:'',
				password:''
			}
		}
	},
	methods:{
		login(){
			this.$store.commit('setLoading',true);
			this.$http.post('auth/login', {
				'username': this.user.login,
				'password': this.user.password
			}).then(response=>{
				// on success
				this.$store.commit('setLoading',false);
				this.$emit('close');
				this.$fire({
					title:this.$t("auth_in"),
					text:this.$t("success"),
					type:"success",
					timer:1700
				});
				this.$store.state.logged=true;
				this.$store.commit('setUser',response.data.user);
			}).catch(error=>{
				this.$store.commit('setLoading',false);
				this.$fire({
					title:this.$t("auth_in"),
					text: error.response.data.message ?? (error.message ?? this.$t('error')),
					type:"error",
				});
			});
		}
	}
}
</script>
<style scoped>
.parent,form{
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}
.parent{
	height: 100%;
}
input,button{
	margin-top:1em;
}
</style>

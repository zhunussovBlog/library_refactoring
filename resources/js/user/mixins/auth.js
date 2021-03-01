import {message_success,message_error} from './messages'

export const login = {
	mixins:[message_success,message_error],
	methods:{
		login(){
			this.$http.post('login', this.user ).then(response=>{
				// on success
				this.$store.dispatch('login',response.data.res);
				this.$emit('close');
				this.message_success('auth_in',response);
			}).catch(error=>{
				this.message_error('auth_in',error);
			});
		}
	}
}

export const logout = {
	mixins:[message_success,message_error],
	methods:{
		logout(){
			this.$http.get('logout').then(response=>{
				this.message_success('auth_out',response);
				this.$store.dispatch('logout');
			}).catch(error=>{
				this.message_error('auth_out',error);
			}).then(final=>{
				this.close();
				this.goTo('home');
			});
		}
	}

}
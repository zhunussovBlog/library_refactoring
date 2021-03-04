import {message_success,message_error} from '../../../mixins/messages'
export default{
	mixins:[message_success,message_error],
	data(){
		return{
			dropdown_links:[
			{
				name:'logout',
				on_click:this.logout
			}
			]
		}
	},
	methods:{
		logout(){
			this.$store.commit('setFullPageLoading',true);
			this.$http.get('logout').then(response=>{
				this.$store.dispatch('logout');
				this.message_success('logout',response);
			}).catch(error=>{
				this.message_error('logout',error);
			}).then(()=>{
				this.$store.commit('setFullPageLoading',false);
			})
		}
	}
}
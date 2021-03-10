import {message_success,message_error} from '../../../mixins/messages'
import {mapGetters} from 'vuex'
export default{
	mixins:[message_success,message_error],
	computed:{
		...mapGetters(['user']),
		dropdown_links(){
			let links=[
			{
				name:'lib_office',
				on_click:this.goToAdmin,
				invisible:!(this.user.is_admin)
			},
			{
				name:'logout',
				on_click:this.logout
			}
			];
			return links
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
		},
		goToAdmin(){
			window.location.replace('/admin');
		}
	}
}
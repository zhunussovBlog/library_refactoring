import {message_error} from './messages'
export const getResults={
	mixins:[message_error],
	methods:{
		getResults(link,commit,after){
			if(!this.$store.getters.fullPageLoading){
				this.$store.commit('setFullPageLoading',true);

				
				let search=this.$store.getters[commit].search;
				let page= this.$store.state[commit].page == 0 ? '' :'?page='+this.$store.state[commit].page;
				
				let add_options=[];
				let request={};

				// validating request for non null
				for(let key in search){
					let value=search[key];
					let searching=false;
					if(typeof value == "object" && value!=null){
						if(Object.keys(value).length>0){
							searching = true;
						}
					}
					else{
						if(value!=null){
							searching=true
						}
					}
					if(searching){
						add_options.push({key:key,value:search[key]});
					}
				}
				
				request.per_page=this.$store.state[commit].per_page;
				request.page=page;
				request.add_options=add_options;

				this.$http.post(link+'/search',request).then(response=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:response.data,searching:true}});
					try{
						after();
					}catch(e){}
				}).catch(error=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:{},searching:false}});
					this.message_error();
				}).then(()=>{
					this.$store.commit('setFullPageLoading',false);
				});
			}
		}
	}
}
export const getAllData={
	mixins:[message_error],
	methods:{
		getAllData(link,commit,max){
			if(!this.$store.getters.fullPageLoading){
				this.$store.commit('setFullPageLoading',true);	
				
				let max_num='';
				if(max){
					max_num='?max='+max;
				}

				let search=max? '&' :'?';

				search+=(this.$store.state[commit].page == 0 ? '' : 'page='+this.$store.state[commit].page);
				search+='&per_page='+ this.$store.state[commit].per_page;

				this.$http.get(link+'/index'+max_num+search).then(response=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:response.data,searching:true}});
				}).catch(error=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:{},searching:false}});
					this.message_error();
				}).then(()=>{
					this.$store.commit('setFullPageLoading',false);
				});
			}
		},
	}
}
export const last={
	methods:{
		last(link,commit,page){
			if(!this.$store.getters.fullPageLoading){
				this.$store.commit('setFullPageLoading',true);
				let store=this.$store.state[commit]
				let changes='?';
				if(store.sort_by.order_by){
					changes+='order_by='+store.sort_by.order_by;
				}
				if(store.sort_by.order_mode){
					changes+='&order_mode='+store.sort_by.order_mode;
				}
				if(store.per_page){
					changes+='&perPage='+store.per_page;
				}
				if(page){
					changes+='&page='+ page;
				}
				this.$http.get(link+'/last'+changes).then(response=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:response.data,page:page ? page : 1}});
					this.$store.commit('setFullPageLoading',false);
				})
			}
		}
	}
}
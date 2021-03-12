import {message_error,message_success} from './messages'
export const getResults={
	mixins:[message_error],
	methods:{
		getResults(link,commit,after){
			this.$store.commit('setFullPageLoading',true);

			
			let search=this.$store.getters[commit].search;
			let page= this.$store.state[commit].page == 0 ? '' :'?page='+this.$store.state[commit].page;
			
			let add_options=[];
			let search_options=[];
			let request={};

			// validating add_options for non null
			for(let key in search.add_options){
				let value=search.add_options[key];
				let searching=false;
				if(typeof value == "object" && value!=null){
					if(Object.keys(value).length>0){
						searching = true;
					}
				}
				else{
					if(value){
						searching=true
					}
				}
				if(searching){
					add_options.push({key:key,value:value});
				}
			}

			//validating search_options for non null
			if(search.search_options != null){
				search_options=search.search_options.filter(item=>item.value!=null);
			}
			
			request.per_page=this.$store.state[commit].per_page;
			request.page=page;
			request.add_options=add_options;
			request.search_options=search_options;

			this.$http.post(link+'/search',request).then(response=>{
				this.$store.dispatch('setStore',{label:commit,data:{data:response.data,searching:true}});
				try{
					after();
				}catch(e){}
			}).catch(error=>{
				this.$store.dispatch('setStore',{label:commit,data:{data:{},searching:false}});
				this.message_error('search',error);
			}).then(()=>{
				this.$store.commit('setFullPageLoading',false);
			});
		}
	}
}
export const getAllData={
	mixins:[message_error],
	methods:{
		getAllData(link,commit,max){
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
				this.message_error('search',error);
			}).then(()=>{
				this.$store.commit('setFullPageLoading',false);
			});
		}
	}
}
export const last={
	methods:{
		last(link,commit,page){
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
export const create_it={
	mixins:[message_error,message_success],
	methods:{
		create_it(link,commit,request,after,afterRequest){
			this.$http.post(link+'/create',request).then(response=>{
				try{
					after(link,commit,afterRequest);
				}catch(e){
					console.error(e);
				}
				this.message_success('create',response);
				this.$emit('close');
			}).catch(error=>{
				this.message_error('create',error);
			}).then(()=>{
				this.$store.commit('setFullPageLoading',false);
			});
		},
	}
}
export const edit_it={
	mixins:[message_error,message_success],
	methods:{
		edit_it(link,commit,request,after,afterCatch){
			this.$http.put(link+'/update',request).then(response=>{
				try{
					after(response.data.success.id);
				}catch(e){
					try{
						afterCatch(link,commit)
					}catch(e){}
				}
				this.message_success('edit',response);
				this.$emit('close');
			}).catch(error=>{
				this.message_error('edit',error);
			}).then(()=>{
				this.$store.commit('setFullPageLoading',false);
			})
		}
	}
}
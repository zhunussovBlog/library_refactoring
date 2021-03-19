import {message_error,message_success} from './messages'
export const getResults={
	mixins:[message_error],
	methods:{
		getResults(link,commit,after){
			this.$store.commit('setFullPageLoading',true);

			
			let store=this.$store.getters[commit];
			let search=this.$store.getters[commit].search;
			
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
				search_options=search.search_options.filter(item=>{
					let searching=false;
					let value=item.value;
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
					return searching
				});
			}
			
			request.per_page=store.per_page;
			request.page=store.page;
			request.add_options=add_options;
			request.search_options=search_options;

			this.$http.post(link+'/search',request).then(response=>{
				let s_request={
					link:'/search',
					body:request,
					mode:'post'
				}
				let data={data:response.data,searching:true,request:s_request};
				if(store.all){
					data.all=response.data.all
				};
				this.$store.dispatch('setStore',{label:commit,data:data});
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
				let s_request={
					link:'/index',
					mode:'get'
				}
				this.$store.dispatch('setStore',{label:commit,data:{data:response.data,searching:true,request:s_request}});
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
		last(link,commit){
			this.$store.commit('setFullPageLoading',true);

			let store=this.$store.state[commit]
			let changes='';

			if(store.request.mode=="post"){
				changes=store.request.body
				if(store.sort_by.order_by){
					changes.order_by=store.sort_by.order_by;
				}
				if(store.sort_by.order_mode){
					changes.order_mode=store.sort_by.order_mode;
				}
				if(store.per_page){
					changes.per_page=store.per_page;
				}
				if(store.page){
					changes.page=store.page;
				}

				this.$http.post(link+store.request.link,changes).then(response=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:response.data}});
				}).then(()=>{
					this.$store.commit('setFullPageLoading',false);
				});
			}
			else{
				changes='?'

				if(store.sort_by.order_by){
					changes+='order_by='+store.sort_by.order_by;
				}
				if(store.sort_by.order_mode){
					changes+='&order_mode='+store.sort_by.order_mode;
				}
				if(store.per_page){
					changes+='&per_page='+store.per_page;
				}
				if(store.page){
					changes+='&page='+ store.page;
				}

				this.$http.get(link+store.request.link+changes).then(response=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:response.data}});
				}).catch((error)=>{
				}).then(()=>{
					this.$store.commit('setFullPageLoading',false);
				});
			}
		}
	}
}
export const last_created={
	methods:{
		last_created(link,commit){
			this.$store.commit('setFullPageLoading',true);
			this.$http.get(link+'/last-created').then(response=>{
				let s_request={
					link:'/last-created',
					mode:'get'
				}
				this.$store.dispatch('setStore',{label:commit,data:{data:response.data,pagination:false,searching:true,request:s_request}});
			}).catch((error)=>{
			}).then(()=>{
				this.$store.commit('setFullPageLoading',false);
			})
		}
	}
}
export const create_it={
	mixins:[message_error,message_success],
	methods:{
		create_it(link,commit,request,after,afterCatch){
			this.$http.post(link+'/create',request).then(response=>{
				try{
					// it is a custom function (when u create smth inside another create)
					after(response.data.res.id);
				}catch(e){}
				try{
					// it usually is last_created
					afterCatch(link,commit);
				}catch(e){}
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
					// it is a custom function (at least it is to close the "more" modal )
					after(response.data.res.id);
				}catch(e){}
				try{
					// it is usually last()
					afterCatch(link,commit)
				}catch(e){}
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
export const download_file={
	methods:{
		download_file(response,name){
			const url = window.URL.createObjectURL(new Blob([response.data]));
			const link = document.createElement('a');
			link.href = url;
			link.setAttribute('download', name);
			document.querySelector('#app').appendChild(link);
			link.click();
		}
	}
}
export const reset = {
	methods:{
		reset(commit){
			let store =this.$store.getters[commit];
			for(let key in store.search.add_options){
				let value=store.search.add_options[key];
				if(Array.isArray(value)){
					store.search.add_options[key]=[]
				}
				else if(typeof value == 'object' && value !== null){
					store.search.add_options[key] = {}
				}
				else{
					store.search.add_options[key]=null
				}
			}
			if(store.search.search_options){
				store.search.search_options=store.search_default;
			}
		}
	}
}
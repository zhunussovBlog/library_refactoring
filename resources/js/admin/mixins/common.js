export const getResults={
	methods:{
		getResults(link,search,commit,after){
			if(!this.$store.getters.fullPageLoading){
				this.$store.commit('setFullPageLoading',true);
				search.per_page=this.$store.state[commit].per_page;
				let page= this.$store.state[commit].page == 0 ? '' :'?page='+this.$store.state[commit].page;
				this.$http.post(link+'/search'+page,search).then(response=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:response.data,searching:true}});
					try{
						after();
					}catch(e){}
					this.$store.commit('setFullPageLoading',false);
				}).catch(error=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:{},searching:false}});
					this.$fire({
						title:this.$t('search'),
						text:messages.error(error),
						type:"error",
					});
					this.$store.commit('setFullPageLoading',false);
				})
			}
		}
	}
}
export const getAllData={
	methods:{
		getAllData(link,commit,max){
			if(!this.$store.getters.fullPageLoading){
				this.$store.commit('setFullPageLoading',true);	
				let max_num='';
				try{
					load(true);
				}catch(e){}
				if(max){
					max_num='?max='+max;
				}
				let search=max? '&' :'?';
				search+=(this.$store.state[commit].page == 0 ? '' : 'page='+this.$store.state[commit].page);
				search+='&per_page='+ this.$store.state[commit].per_page;
				this.$http.get(link+'/index'+max_num+search).then(response=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:response.data,searching:true}});
					this.$store.commit('setFullPageLoading',false);
				}).catch(error=>{
					this.$store.dispatch('setStore',{label:commit,data:{data:{},searching:false}});
					this.$fire({
						title:this.$t('search'),
						text:messages.error(error),
						type:"error",
					});
					this.$store.commit('setFullPageLoading',false);
				})
			}
		},
	}
}
export const reset={
	// need to delete this part later
	methods:{
		reset(search,commit){
			// !!
			search({});
			this.$store.dispatch('setStore',{label:commit,data:{data:{},searching:false}});
		}
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
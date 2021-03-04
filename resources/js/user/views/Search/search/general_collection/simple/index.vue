<template>
	<form @submit.prevent="search" class="position-relative">
		<select-div :data="select_data" label="name" class="w-min-120 p-3 border-grey no-border-right no-border-right-radius border-width bg-white" labelClasses="text-no-wrap" v-model="type"/>
		<div id="warn-simple" class="warn">{{$t('at_least_2')}}</div>
		<autocomplete class="flex-fill mr--5" input_classes="rounded-0 border-grey" :placeholder="$t('search_books&media',{type:$t(type.name+'_by')})" v-model="query" :results="autocomplete_results" :submit_method="search"/>
		<button type="submit" class="border-grey w-min-120">{{$t('search')}}</button>
	</form>
</template>
<script type="text/javascript">
	// components
	import SelectDiv from '../../../../../components/select'
	import autocomplete from '../../components/autocomplete'
	// mixins
	import {goTo} from '../../../../../mixins/goTo'
	import {selectData} from '../../../../../mixins/search'
	export default{
		components:{
			SelectDiv,
			autocomplete
		},
		mixins:[goTo,selectData],
		data(){
			return{
				query:'',
				type:'',
				autocomplete_results:[]
			}
		},
		watch:{
			query(newValue){
				this.getAutocomplete();
			}
		},
		methods:{
			getAutocomplete(){
				if(!this.$mobileCheck()){
					try{
						this.$store.getters.request.cancel();
					}
					catch(e){}
					this.$store.commit('setRequest',this.$http.CancelToken.source());
					if(this.query!='' && !this.$store.getters.loading){
						this.$http.get('media/autocomplete?value=' + this.query+'&key='+this.type.key+'&max='+10,{cancelToken:this.$store.getters.request.token})
						.then(response => {
							this.autocomplete_results = response.data.res;
						})
					}
				}
			},
			search(){
				let key=this.type.key;
				let query=this.query;
				let options=[{key:key,value:query}]
				let request={
					search_options:options
				};
				this.$store.commit('setFullPageLoading',true);
				this.$http.post('media/search',request).then(response=>{
					this.$store.dispatch('setSearches',response);
					this.$store.commit('setQuery','"'+this.$t(key)+' : '+query+'"')
					this.$store.commit('setSearchRequest',options);
					this.$store.commit('setFullPageLoading',false);
					this.$store.commit('setSearching',true)
					this.goTo('search');
				})
			}
		}
	}
</script>

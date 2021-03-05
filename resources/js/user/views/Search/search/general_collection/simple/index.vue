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
	import {selectData,performSearch} from '../../../../../mixins/search'
	import validate from '../../../../../mixins/validate'
	import warn from '../../../../../mixins/warn'
	export default{
		components:{
			SelectDiv,
			autocomplete
		},
		mixins:[selectData,performSearch,warn,validate],
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
				if(this.validate(query)){
					this.warn('simple',false);
					let options=[{key:key,value:query}]
					let request={
						search_options:options
					};

					query=this.$t(key)+' : '+query;
					
					this.performSearch(request,query,options);
				}
				else{
					this.warn('simple',true);
				}
			}
		}
	}
</script>

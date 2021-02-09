<template>
	<div id="results" class="relative" v-if="query">
		<div v-if="Object.keys(results).length>0">
			<div class="title padding ">{{$t('results_for')}} "<span class="color-orange">{{query}}</span>"</div>
			<div id="excel" class="pd-18-auto bg-light-gray padding  mt-40 align-items-center">
				<div class="filter-width">{{results.total}} {{$t('results')}},&nbsp; {{results.last_page}} {{$t('pages')}}</div>
				<div id="select" class="align-items-center justify-content-between flex-grow">
					<div class="align-items-center">
						<Checkbox @change="selectAll()" :checked="selected.all"/> 
						&nbsp; {{$t('select_all')}}
						({{selected.all ? results.total - selected.data.length : selected.data.length}})
					</div>
					<button @click="saveExcel()">{{$t('export_all')}}</button>
				</div>
			</div>
			<div class="b-1k cursor-pointer padding mb-15 mt-15" @click="showFilter()">
				<filter-icon /> &nbsp;
				{{$t('filter')}}
			</div>
			<div class="hidden transition full-width" :class="filterShown ? 'shown overflow-hidden' : 'overflow-hidden'">
				<filter-div class="b-1k pd-20 padding"/>
			</div>
			<div class="padding row align-items-start" :class="$mobileCheck ? 'mt-15' :'mt-40'">
				<filter-div class="n-1k pd-20"/>
				<div class="full-width">
					<div class="results_data">
						<BookCard v-for="(result,index) in results.data" :data="result" :key="index"/>
					</div>
				</div>
			</div>
			<div class="padding mt-40 mb-40 row">
				<div class="filter-width n-1k"></div>
				<pagination-div/>
			</div>
		</div>
		<div v-else class="padding mt-40 mb-40"><div v-if="!$store.getters.loading">{{$t('no_data')}}</div></div>
	</div>
</template>
<script type="text/javascript">
// components
import BookCard from './BookCard'
import Filter from './Filter'
import Pagination from './Pagination'
import Checkbox from '../../../components/common/Checkbox'

// mixins
import saveExcel from '../../../mixins/saveExcel'

// icons
import FilterIcon from '../../../assets/icons/Filter'

export default{
	mixins:[saveExcel],
	components:{BookCard,'filter-div':Filter,'pagination-div':Pagination,Checkbox,"filter-icon":FilterIcon},
	computed:{
		// <!-- you get results from store -->
		results(){
			return this.$store.getters.results;
		},
		query(){
			let queries=this.$store.getters.queries
			let search='';
			queries.forEach(query=>{
				if(query.operator){
					search+=' '+this.$t(query.operator).toLowerCase()+' '
				}
				search+=this.$t(query.type) + ': ' + query.query;
			});
			return search;
		},
		advSearch(){
			return this.$store.getters.advSearch;
		}
	},
	data(){
		return {
			filterShown:false
		}
	},
	methods:{
		objectWithoutKey(obj,key){
			return objectWithoutKey(obj,key)
		},
		showFilter(){
			if(!this.filterShown){
				let doc=document.getElementsByClassName('hidden')[0];
				setTimeout(()=>{
					doc.classList.remove('overflow-hidden');

				},300);
			}
			this.filterShown=!this.filterShown;
		}
	}
}
</script>
<style scoped>
#results{
	background-color: white;
	/*hard ... has to be hard code*/
	padding-top: 5em;
}
.hidden{
	max-height: 0;
}
.shown{
	max-height: 31.25em;
}
</style>
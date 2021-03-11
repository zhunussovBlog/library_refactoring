<template>
	<form class="col" @submit.prevent="loadResults()">
		<div class="d-flex flex-1">
			<div class="pad w-100">
				<input type="text" v-model="search.from" required />
				<label class="placeholder required">From</label>
			</div>
			<div class="pad w-100">
				<input type="text" v-model="search.count" required />
				<label class="placeholder required">Count</label>
			</div>
			<div class="pad forth">
				<button type="submit">{{$t('search')}}</button>
			</div>
			<div class="pad forth">
				<button type="button">{{$t('reset')}}</button>
			</div>
		</div>
		<div class="mt-5">
			<div v-if="searching">
				<table-div class="mt-5" :heads="heads" :data="data.res" link="/report/book-history" commit="books_inv_number" :sortable="false" :tableName="{countable:true,name:'books'}" :clickables="false"/>
			</div>
		</div>
	</form>
</template>
<script type="text/javascript">
// components
import Table from '../../../components/common/Table'

// loading indicator
import PulseLoader from 'vue-spinner/src/PulseLoader'

//mixins
import {getResults,reset} from '../../../mixins/common'

export default{
	mixins:[getResults,reset],
	components:{'table-div':Table,PulseLoader},
	computed:{
		data(){
			return this.$store.getters.books_inv_number.data;
		},
		searching(){
			return this.$store.getters.books_inv_number.searching;
		}
	},
	data(){
		return{
			loading:false,
			search:{
				from:'',
				count:''
			},
			// heads:[
			// {name:'barcode',link:'barcode'},
			// {name:'inventory_number',link:'inv_id'},
			// {name:'type',link:'type'},
			// {name:'titles',link:'title',countable:true},
			// {name:'author',link:'author'},
			// {name:'bord-flex_date',link:'bord-flex_date',is_date:true},
			// {name:'due_date',link:'due_date',is_date:true},
			// {name:'delivery_date',link:'delivery_date',is_date:true},
			// {name:'status',link:'status'},
			// {name:'give_material',func:this.giveMaterial},
			// {name:'last_user_bord-flexed',link:'username'},
			// ]
		}
	},
	methods:{
		setLoading(bool){
			this.loading=bool;
		},
		setSearch(search){	
			this.search=search;
		},
		loadResults(){
			this.$store.dispatch('setStore',{label:'books_inv_number',data:{page:0}});
			this.getResults('/report/inv-book',this.search,'books_inv_number');
		},
		giveMaterial(info){
			alert('not available');
		}
	}
}
</script>
<style scoped></style>
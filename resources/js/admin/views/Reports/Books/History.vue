<template>
	<form @submit.prevent="loadResults()">
		<div class="d-flex">
			<div class="pad col-2">
				<select v-model="search.type" required>
					<option v-for="(type,index) in types" :value="type.key">{{$t(type.key)}}</option>
				</select>
				<label class="placeholder required">{{$t('type')}}</label>
			</div>
			<div class="pad w-100">
				<input type="text" placeholder=" " v-model="search.query">
				<label class="placeholder">{{$t('searching')}}</label> 
			</div>
			<div class="pad col-2">
				<button type="submit">{{$t('search')}}</button>
			</div>
			<div class="pad col-2">
				<button type="button" @click="reset(setSearch,'books')">{{$t('reset')}}</button>
			</div>
		</div>
		<div class="mt-5">
			<div v-if="searching">
				<table-div class="mt-5" :heads="heads" :data="data.res" link="/report/book-history" commit="books_history" :sortable="false" :tableName="{countable:true,name:'books'}"/>
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
			return this.$store.getters.books_history.data;
		},
		searching(){
			return this.$store.getters.books_history.searching;
		}
	},
	data(){
		return{
			loading:false,
			types:[],
			search:{
				type:'',
				query:''
			},
			heads:[
			{name:'barcode',link:'barcode'},
			{name:'inventory_number',link:'inv_id'},
			{name:'type',link:'type'},
			{name:'titles',link:'title',countable:true},
			{name:'author',link:'author'},
			{name:'bord-flex_date',link:'bord-flex_date',is_date:true},
			{name:'due_date',link:'due_date',is_date:true},
			{name:'delivery_date',link:'delivery_date',is_date:true},
			{name:'status',link:'status'},
			{name:'give_material',func:this.giveMaterial},
			{name:'last_user_bord-flexed',link:'username'},
			]
		}
	},
	methods:{
		getTypes(){
			this.$http.get('/report/book-history/types').then(response=>{
				this.types=response.data.res;
			})
		},
		setLoading(bool){
			this.loading=bool;
		},
		setSearch(search){	
			this.search=search;
		},
		loadResults(){
			this.$store.dispatch('setStore',{label:'books_history',data:{page:0}});
			this.getResults('/report/book-history',this.search,'books_history');
		},
		giveMaterial(info){
			alert('not available');
		}
	},
	created(){
		this.getTypes();
	}
}
</script>
<style scoped></style>
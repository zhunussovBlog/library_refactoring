<template>
	<form @submit.prevent="loadResults()">
		<div class="d-flex">
			<div class="pad w-100">
				<input type="text" placeholder=" " v-model="books_history.search.add_options.barcode">
				<label class="placeholder">{{$t('barcode')}}</label> 
			</div>
			<div class="pad w-100">
				<input type="text" placeholder=" " v-model="books_history.search.add_options.id">
				<label class="placeholder">{{$t('inventory_number')}}</label> 
			</div>
		</div>
		<div class="d-flex mt-2">
			<div class="pad w-100">
				<input type="text" placeholder=" " v-model="books_history.search.add_options.author">
				<label class="placeholder">{{$t('author')}}</label> 
			</div>
			<div class="pad w-100">
				<input type="text" placeholder=" " v-model="books_history.search.add_options.title">
				<label class="placeholder">{{$t('title')}}</label> 
			</div>
		</div>
		<div class="d-flex justify-content-end">
			<div class="pad col-1">
				<button type="submit">{{$t('search')}}</button>
			</div>
			<div class="pad col-1">
				<button type="button" @click="reset(commit)">{{$t('reset')}}</button>
			</div>
		</div>
		<div v-if="books_history.searching">
			<table-div 
			class="mt-5"
			:heads="heads"
			:data="books_history.data.res"
			:link="link"
			:commit="commit"
			:sortable="false"
			/>
		</div>
	</form>
</template>
<script type="text/javascript">
// components
import Table from '../../../components/common/Table'

//mixins
import {getResults,reset} from '../../../mixins/common'

import {mapGetters} from 'vuex'

export default{
	mixins:[getResults,reset],
	components:{'table-div':Table},
	computed:{
		...mapGetters(['books_history'])
	},
	data(){
		return{
			types:[],
			heads:[
			{name:'barcode',link:'barcode'},
			{name:'inventory_number',link:'id'},
			{name:'type',link:'type'},
			{name:'titles',link:'title',countable:true},
			{name:'author',link:'author'},
			{name:'borrow_date',link:'borrow_date',is_date:true},
			{name:'due_date',link:'due_date',is_date:true},
			{name:'delivery_date',link:'delivery_date',is_date:true},
			{name:'status',link:'status'},
			{name:'last_user_borrowed',link:'username'},
			],
			link:'/book-history',
			commit:'books_history'
		}
	},
	methods:{
		getTypes(){
			this.$http.get(this.link+'/types').then(response=>{
				this.types=response.data.res;
			})
		},
		loadResults(){
			this.$store.dispatch('setStore',{label:this.commit,data:{page:0}});
			this.getResults(this.link,this.commit);
		}
	},
	created(){
		this.getTypes();
	}
}
</script>

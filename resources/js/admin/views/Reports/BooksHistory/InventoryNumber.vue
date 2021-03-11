<template>
	<div class="d-flex flex-folumn">
		<form class="d-flex flex-fill" @submit.prevent="loadResults()">
			<div class="pad flex-fill">
				<input type="text" v-model="search.from" required />
				<label class="placeholder required">From</label>
			</div>
			<div class="pad flex-fill">
				<input type="text" v-model="search.count" required />
				<label class="placeholder required">Count</label>
			</div>
			<div class="pad col-1">
				<button type="submit">{{$t('search')}}</button>
			</div>
			<div class="pad col-1">
				<button type="button">{{$t('reset')}}</button>
			</div>
		</form>
		<div v-if="searching">
			<table-div class="mt-5" :heads="heads" :data="data.res" link="/report/inv-book" commit="books_inv_number" :sortable="false" :tableName="{countable:true,name:'books'}" :clickables="false" :pagination="false"/>
			<div class="d-flex mt-4">
				<button class="width-unset mr-4" @click="print()">{{$t('print')}}</button>
				<button class="width-unset" @click="exportToExcel()">{{$t('export')}}</button>
			</div>
		</div>
	</div>
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
			heads:[
			{name:'author_title',link:'author_title'},
			{name:'year_city',link:'year_city'},
			{name:'call_number',link:'call_number'},
			{name:'barcode',link:'barcode'},
			{name:'cost',link:'cost'},
			{name:'currency',link:'currency'},
			{name:'document_number',link:'doc_no'},
			{name:'batch_id',link:'batch_id'},
			{name:'inventory_number',link:'inventory_no'},
			{name:'create_date',link:'create_date',is_date:true},
			]
		}
	},
	methods:{
		loadResults(){
			this.$store.dispatch('setStore',{label:'books_inv_number',data:{page:0}});
			this.getResults('/report/inv-book',this.search,'books_inv_number');
		},
		print(){
			this.$store.commit('setFullPageLoading',true);	
			this.$http.get('/report/inv-book/print/'+this.$i18n.locale,{responseType:'blob'}).then(response=>{
				const url = window.URL.createObjectURL(new Blob([response.data]));
				const link = document.createElement('a');
				link.href = url;
				link.setAttribute('download', 'media.pdf');
				document.querySelector('#app').appendChild(link);
				this.$store.commit('setFullPageLoading',false);	
				link.click();
			})
		},
		exportToExcel(){
			this.$store.commit('setFullPageLoading',true);	
			this.$http.get('/report/inv-book/export/'+this.$i18n.locale,{responseType:'blob'}).then(response=>{
				const url = window.URL.createObjectURL(new Blob([response.data]));
				const link = document.createElement('a');
				link.href = url;
				link.setAttribute('download', 'media.xlsx');
				document.querySelector('#app').appendChild(link);
				this.$store.commit('setFullPageLoading',false);	
				link.click()
			})
		}
	}
}
</script>
<style scoped></style>
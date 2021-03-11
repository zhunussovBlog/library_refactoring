<template>
	<div class="p-2">
		<form class="bg-white p-3 rounded-lg" @submit.prevent="search()">
			<div class="pad font-weight-bold font-size-20">Search most read books</div>
			<div class="d-flex align-items-center mt-2">
				<div class="d-flex flex-fill">
					<div class="pad flex-fill">
						<input type="date"  v-model="request.from_date"/>
						<label class="placeholder">From date</label>
					</div>
					<div class="pad flex-fill">
						<input type="date" 	v-model="request.to_date"/>
						<label class="placeholder">To date</label>
					</div>
				</div>
				<div class="d-flex align-items-center flex-fill">
					<div class="pad d-flex ml-5">
						<button type="submit">{{$t('search')}}</button>
						<button type="button" class="ml-2" @click="reset()">{{$t('reset')}}</button>
					</div>
				</div>
			</div>
			<div v-if="most_read.searching">
				<table-div 
				class="margin-top" 
				:heads="heads"
				:data="most_read.data.res" 
				link="/report/most-read" 
				commit="most_read"
				/>
			</div>
		</form>
	</div>
</template>
<script type="text/javascript">
// components
import TableDiv from '../../../components/common/Table'

// mixins
import {getResults} from '../../../mixins/common'
export default {
	components:{
		TableDiv
	},
	mixins:[getResults],
	computed:{
		most_read(){
			return this.$store.getters.most_read;
		}
	},
	data(){
		return{
			heads:[
			{name:'author',link:'author'},
			{name:'title',link:'title'},
			{name:'language',link:'language'},
			{name:'isbn',link:'isbn'},
			{name:'count_issue',link:'count_issue'},
			],
			most_read_data:{},
			request:{
				from_date:'',
				to_date:''
			}
		}
	},
	methods:{
		search(){
			this.$store.dispatch('setStore',{label:'most_read',data:{page:0}});
			this.getResults('/report/most-read',this.request,'most_read');
		},
		getInitData(){
			let request={};
			let now=new Date();
			request.from_date='01.08.2020';
			request.to_date=now.getDate()+'.'+now.getMonth()+'.'+now.getFullYear();
			this.$http.post('/report/most-read/search',request).then(response=>{
				this.most_read_data=response.data.res;
			})
		}
	},
	created(){
		this.getInitData();
	}
}		
</script>
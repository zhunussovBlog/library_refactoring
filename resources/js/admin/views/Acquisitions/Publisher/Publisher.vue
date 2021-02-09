<template>
	<form class="row" @submit.prevent="loadResults()">
		<div class="bg-white mt-10 full-width pd-20 ">
			<div class="justify-content-between">
				<div class="width-40">
					<input-div :search="true" :onSubmit="loadResults" v-model="search.name" :placeholder="$t('search_by',{type:$t('name_by')})" />
				</div>
				<div class="align-items-center">
					<button type="button" @click="showModal(CreatePublisher,{loadAll:getAllData})">{{$t('create_publisher')}}</button>
					<button type="button" class="ml-10" @click="loadAllData()">{{$t('load_all')}}</button>
				</div>
			</div>
			<div class="margin-top">
				<div v-if="publishers.searching">
					<table-div class="margin-top" :heads="heads" :data="publishers.data.res" :editObj="editObj" :deleteObj="deleteObj" link="/publisher" commit="publishers"/>
				</div>
			</div>
		</div>
	</form>
</template>
<script type="text/javascript">
// mixins
import showModal from '../../../mixins/showModal'
import {getResults,getAllData} from '../../../mixins/common'

// components
import CreatePublisher from './CreatePublisher'
import table from '../../../components/common/Table'
import input from '../../../components/common/Input'

export default{
	mixins:[showModal,getResults,getAllData],
	components:{
		'table-div':table,
		'input-div':input
	},
	computed:{
		publishers(){
			return this.$store.getters.publishers;
		},
	},
	data(){
		return{
			CreatePublisher:CreatePublisher,
			heads:[
			{name:'name',link:'name'},
			{name:'commercial_name',link:'com_name'},
			{name:'address',link:'address'},
			{name:'email',link:'email'},
			{name:'phone',link:'phone'},
			{name:'fax',link:'fax'},
			],
			editObj:{
				available:true,
				component:CreatePublisher
			},
			deleteObj:{
				available:true,
				link:'/publisher/delete',
			},
			search:{
				name:null
			},
		}
	},
	methods:{
		loadResults(){
			this.$store.dispatch('setStore',{label:'publishers',data:{page:0}});
			this.getResults('/publisher',this.search,'publishers')
		},
		loadAllData(){
			this.$store.dispatch('setStore',{label:'publishers',data:{page:0}});
			this.getAllData('/publisher','publishers');
		}
	}
}
</script>
<template>
	<form class="d-flex" @submit.prevent="loadResults()">
		<div class="bg-white mt-2 w-100 p-3">
			<div class="d-flex justify-content-between">
				<div class="col-6">
					<input-div :search="true" :onSubmit="loadResults" v-model="suppliers.search.add_options.name" :placeholder="$t('search_by',{type:$t('name_by')})" />
				</div>
				<div class="d-flex align-items-center">
					<button type="button" @click="showModal(CreateSupplier,{loadAll:getAllData})">{{$t('create_supplier')}}</button>
					<button type="button" class="ml-2" @click="loadAllData()">{{$t('load_all')}}</button>
				</div>
			</div>
			<div class="mt-5">
				<div v-if="suppliers.searching">
					<table-div
					class="mt-5"
					:heads="heads"
					:data="suppliers.data.res"
					:editObj="editObj"
					:deleteObj="deleteObj" 
					:link="link"
					:commit="commit"
					:pagination="suppliers.pagination"
					/>
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
import CreateSupplier from './CreateSupplier'
import table from '../../../components/Table'
import input from '../../../components/Input'

import {mapGetters} from 'vuex'

export default{
	mixins:[showModal,getResults,getAllData],
	components:{
		'table-div':table,
		'input-div':input
	},
	computed:{
		...mapGetters(['suppliers'])
	},
	data(){
		return{
			CreateSupplier:CreateSupplier,
			heads:[
			{name:'name',link:'name'},
			{name:'commercial_name',link:'com_name'},
			{name:'bin',link:'bin'},
			{name:'address',link:'address'},
			{name:'email',link:'email'},
			{name:'phone',link:'phone'},
			{name:'fax',link:'fax'},
			],
			editObj:{
				available:true,
				component:CreateSupplier
			},
			deleteObj:{
				available:true,
			},
			link:'/supplier',
			commit:'suppliers'
		}
	},
	methods:{
		loadResults(){
			this.$store.dispatch('setStore',{label:this.commit,data:{page:0}});
			this.getResults(this.link,this.commit)
		},
		loadAllData(){
			this.$store.dispatch('setStore',{label:this.commit,data:{page:0}});
			this.getAllData(this.link,this.commit);
		}
	}
}
</script>
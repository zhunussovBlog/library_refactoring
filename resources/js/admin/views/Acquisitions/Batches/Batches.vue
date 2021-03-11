<template>
	<form class="d-flex" @submit.prevent="loadResults()">
		<!-- filter -->
		<div class="mt-2 ml-2 bg-white rounded-lg col-2"><filter-div /></div>
		<!-- everything else -->
		<div class="mt-2 mx-2 bg-white rounded-lg flex-fill p-3">
			<div class="d-flex align-items-center justify-content-between">
				<div class="w-50 ">
					<input-div 
						:placeholder="$t('search_by',{type:$t('batches_by')})"
						:search='true'
						:onSubmit="loadResults"
						v-model="batches.search.batch_id"
					/>
				</div>
				<div class="d-flex align-items-center" >
					<button type="button" @click="showModal(CreateBatches)">
						<span><Plus /> &nbsp;</span>
						<span>{{($t('add_batch'))}}</span>
					</button>
					<button class="ml-2" type="button" @click="loadAllData()">
						<span><Download /> &nbsp;</span>
						<span>{{$t('load_all')}}</span>
					</button>
				</div>
			</div>
			<div class="mt-5">
				<div v-if="batches.searching">
					<table-div 
						class="mt-5" 
						:heads="heads"
						:data="batches.data.res" 
						:status='true' 
						:editObj="editObj" 
						:deleteObj="deleteObj" 
						:showMore="showMore" 
						link="/batch" 
						commit="batches"
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

// common components
import Table from '../../../components/common/Table'
import More from '../../../components/common/More'
import Input from '../../../components/common/Input'

// batches only components
import CreateBatches from './CreateBatches'
import Filter from './Filter'

// icons
import Download from '../../../assets/icons/Download'
import Plus from '../../../assets/icons/Plus'

export default{
	mixins:[showModal,getResults,getAllData],
	components:{
		'table-div':Table,
		'filter-div':Filter,
		'input-div':Input,
		Download,
		Plus
	},
	computed:{
		batches(){
			return this.$store.getters.batches;
		}
	},
	data(){
		return{
			CreateBatches:CreateBatches,
			More:More,
			heads:[
			{name:'batches_number',link:'id'},
			{name:'quantity_titles',link:'titles_no'},
			{name:'quantity_items',link:'items_no'},
			{name:'create_date',link:'create_date',is_date:true},
			{name:'created_by',link:'created_by'},
			{name:'edited_by',link:'edited_by'},
			],
			editObj:{
				available:true,
				component:CreateBatches
			},
			deleteObj:{
				available:true,
				link:'/batch/delete',
			},
			showMore:{
				available:true,
				title:'show_more',
				func:this.showit
			}
		}
	},
	methods:{
		loadAllData(){
			this.$store.dispatch('setStore',{label:'batches',data:{page:0}});
			this.getAllData('/batch','batches');
		},
		loadResults(){
			this.$store.dispatch('setStore',{label:'batches',data:{page:0}});
			this.getResults('/batch',this.batches.search,'batches');
		},
		showit(info){
			// show More_info modal
			let heads=[{name:'batches_number',link:'id'},
			{name:'invoice_date',link:'inv_date',is_date:true},
			{name:'type_of_supply',link:'sup_type'},
			{name:'suppliers',link:'supplier'},
			{name:'cost',link:'cost'},
			{name:'quantity_titles',link:'titles_no'},
			{name:'quantity_items',link:'items_no'},
			{name:'document_number',link:'doc_no'},
			{name:'contract_number',link:'contract_no'},
			{name:'invoice_details',link:'inv_details'},
			{name:'created_by',link:'username'},
			{name:'create_date',link:'create_date',is_date:true}];
			let props={
				data:info,
				heads:heads,
				width:'35%',
				editObj:this.editObj,
				deleteObj:this.deleteObj,
				link:'/batch',
				commit:'batches'
			};
			this.showModal(this.More,props);
		}
	}
}
</script>
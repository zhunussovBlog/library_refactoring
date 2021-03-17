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
					v-model="batches.search.add_options.id"
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
					:link="link" 
					:commit="commit"
					:pagination="batches.pagination"
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
import TableDiv from '../../../components/common/Table'
import More from '../../../components/common/More'
import InputDiv from '../../../components/common/Input'

// batches only components
import CreateBatches from './CreateBatches'
import FilterDiv from './Filter'

// icons
import Download from '../../../assets/icons/Download'
import Plus from '../../../assets/icons/Plus'

import {mapGetters} from 'vuex'

export default{
	mixins:[showModal,getResults,getAllData],
	components:{
		TableDiv,
		FilterDiv,
		InputDiv,
		Download,
		Plus
	},
	computed:{
		...mapGetters(['batches'])
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
			},
			showMore:{
				available:true,
				title:'show_more',
				func:this.showit
			},
			link:'/batch',
			commit:'batches'
		}
	},
	methods:{
		loadAllData(){
			this.$store.dispatch('setStore',{label:this.commit,data:{page:0}});
			this.getAllData(this.link,this.commit);
		},
		loadResults(){
			this.$store.dispatch('setStore',{label:this.commit,data:{page:0}});
			this.getResults(this.link,this.commit);
		},
		showit(info){
			// show More_info modal
			let heads=[{name:'batches_number',link:'id'},
			{name:'invoice_date',link:'invoice_date',is_date:true},
			{name:'type_of_supply',link:'sup_type'},
			{name:'suppliers',link:'supplier'},
			{name:'cost',link:'cost'},
			{name:'quantity_titles',link:'titles_no'},
			{name:'quantity_items',link:'items_no'},
			{name:'document_number',link:'doc_no'},
			{name:'contract_number',link:'contract_no'},
			{name:'invoice_details',link:'invoice_details'},
			{name:'created_by',link:'created_by'},
			{name:'create_date',link:'create_date',is_date:true}];
			let props={
				data:info,
				heads:heads,
				width:'35%',
				editObj:this.editObj,
				deleteObj:this.deleteObj,
				link:this.link,
				commit:this.commit
			};
			this.showModal(this.More,props);
		}
	}
}
</script>
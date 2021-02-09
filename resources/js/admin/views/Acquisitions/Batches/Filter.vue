<template>
	<div class="pd-20">
		<div class="justify-content-between align-items-end">
			<div class="font-weight-500">{{$t('batch_filter')}}</div>
			<div class="color-gray cursor-pointer font-size-0875" @click="$store.dispatch('resetBatches')">{{$t('reset')}}</div>
		</div>
		<div class="color-gray font-size-075 font-weight-500 mt-20">{{$t("status")}}:</div>
		<div v-for="(status,index) in statuses" class="mt-10 justify-content-between">
			<div class="font-size-0875">{{status.status_title}}</div>
			<div><Checkbox :checked="batches.search.statuses.includes(status.status)" @change="addStatus(status)"/></div>
		</div>
		<div class="color-gray font-size-075 font-weight-500 mt-20">{{$tc('suppliers',1)}}:</div>
		<input-div 
			:autocomplete="{available:true,data:suppliers}" 
			:selectable="{available:true,data:suppliers}" 
			v-model="batches.search.sup_id" 
			head="name" 
			body="id" 
			class="mt-10" 
		/>
		<div class="color-gray font-size-075 font-weight-500 mt-20">{{$t('invoice_date')}}:</div>
		<div class="mt-10 relative">
			<input type="date" v-model="batches.search.start_date"/>
			<label class="placeholder color-gray">
				{{$t('from')}}
			</label>
		</div>
		<div class="mt-10 relative">
			<input type="date" v-model="batches.search.end_date"/>
			<label class="placeholder color-gray">
				{{$t('until')}}
			</label>
		</div>
		<div class="color-gray font-size-075 font-weight-500 mt-20">{{$t('cost')}}:</div>
		<div class="align-items-center justify-content-between">
			<div>
				<input type="text" :placeholder="$t('from')" v-model="batches.search.from_cost">
			</div>
			<div class="ml-10">
				<input type="text" :placeholder="$t('until')" v-model="batches.search.until_cost">
			</div>
		</div>
		<div class="height-1 bg-light-gray mt-20" />
		<button class="outline-orange mt-20" type="submit">{{$t('save_&_search')}}</button>
	</div>
</template>
<script type="text/javascript">
// components
import Checkbox from '../../../components/common/Checkbox'
import Input from '../../../components/common/Input'

export default {
	components:{
		'input-div':Input,
		Checkbox
	},
	computed:{
		batches(){
			return this.$store.state.batches;
		}
	},
	data(){
		return{
			statuses:[],
			suppliers:[],
		}
	},
	methods:{
		getSuppliers(){
			this.$http.get('/supplier/names').then(response=>{
				this.suppliers=response.data.res;
			})
		},
		getStatuses(){
			this.$http.get('/batch/statuses').then(response=>{
				this.statuses=response.data.res;
			})
		},
		addStatus(status){
			let selected = this.batches.search.statuses;
			if(selected.includes(status.status)){
				selected.splice(selected.indexOf(status.status),1);
			}
			else{
				selected.push(status.status);
			}
		}
	},
	created(){
		this.getSuppliers();
		this.getStatuses();
	}
}
</script>
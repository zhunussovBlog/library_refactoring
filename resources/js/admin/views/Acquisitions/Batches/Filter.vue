<template>
	<div class="p-3">
		<div class="d-flex justify-content-between align-items-center">
			<div class="font-weight-bold">{{$t('batch_filter')}}</div>
			<div class="text-grey cursor-pointer font-size-14" @click="$store.dispatch('resetBatches')">{{$t('reset')}}</div>
		</div>
		<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t("status")}}:</div>
		<div v-for="(status,index) in statuses" class="d-flex justify-content-between align-items-center mt-2">
			<div class="font-size-14">{{status.status_title}}</div>
			<div><Checkbox :checked="batches.search.status_key.includes(status.status)" @change="addStatus(status)"/></div>
		</div>
		<div class="text-grey font-size-12 font-weight-bold mt-3">{{$tc('suppliers',1)}}:</div>
		<input-div 
			:autocomplete="{available:true,data:suppliers}" 
			:selectable="{available:true,data:suppliers}" 
			v-model="batches.search.sup_id" 
			head="name" 
			body="id" 
			class="mt-2" 
		/>
		<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('invoice_date')}}:</div>
		<div class="mt-2 position-relative">
			<input type="date" v-model="batches.search.invoice_date.from"/>
			<label class="placeholder text-grey">
				{{$t('from')}}
			</label>
		</div>
		<div class="mt-2 position-relative">
			<input type="date" v-model="batches.search.invoice_date.to"/>
			<label class="placeholder text-grey">
				{{$t('until')}}
			</label>
		</div>
		<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('create_date')}}:</div>
		<div class="mt-2 position-relative">
			<input type="date" v-model="batches.search.create_date.from"/>
			<label class="placeholder text-grey">
				{{$t('from')}}
			</label>
		</div>
		<div class="mt-2 position-relative">
			<input type="date" v-model="batches.search.create_date.to"/>
			<label class="placeholder text-grey">
				{{$t('until')}}
			</label>
		</div>
		<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('edit_date')}}:</div>
		<div class="mt-2 position-relative">
			<input type="date" v-model="batches.search.edit_date.from"/>
			<label class="placeholder text-grey">
				{{$t('from')}}
			</label>
		</div>
		<div class="mt-2 position-relative">
			<input type="date" v-model="batches.search.edit_date.to"/>
			<label class="placeholder text-grey">
				{{$t('until')}}
			</label>
		</div>
		<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('cost')}}:</div>
		<div class="d-flex align-items-center justify-content-between">
			<div>
				<input type="text" :placeholder="$t('from')" v-model="batches.search.cost.from">
			</div>
			<div class="ml-2">
				<input type="text" :placeholder="$t('until')" v-model="batches.search.cost.to">
			</div>
		</div>
		<div class="height-1 bg-lightgrey mt-3" />
		<button class="outline-orange mt-3" type="submit">{{$t('save_&_search')}}</button>
	</div>
</template>
<script type="text/javascript">
// components
import Checkbox from '../../../components/common/Checkbox'
import InputDiv from '../../../components/common/Input'

export default {
	components:{
		InputDiv,
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
			let selected = this.batches.search.status_key;
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
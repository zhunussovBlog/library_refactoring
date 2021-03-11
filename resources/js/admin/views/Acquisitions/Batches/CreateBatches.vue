<template>
	<form @submit.prevent="save()">
		<!-- it's used for both create and edit -->
		<div class="title mt-0">{{$t((edit ?'edit':'create')+'_batches')}}</div>
		
		<div class="d-flex">
			<div class="pad w-100">
				<input type="string" v-model="batch.cost" required />
				<!-- placeholder is needed only when it's required or we really need a placeholder -->
				<label class="placeholder required">{{$t('cost')}}</label>
			</div>
			<div class="pad w-100 select">
				<select v-model="batch.sup_type">
					<option value=''>&nbsp;</option>
					<option value="D">Donated</option>
					<option value="B">Bought</option>
				</select>
				<label class="placeholder">{{$t('type_of_supply')}}</label>
			</div>
		</div>
		<div class="d-flex">
			<div class="d-flex w-100">
				<div class="pad w-100">
					<input type="date" v-model="batch.inv_date" required/>
					<label class="placeholder required">{{$t('invoice_date')}}</label>
				</div>
			</div>
			<div class="d-flex w-100">
				<div class="pad w-100 select">
					<select v-model="batch.sup_id">
						<option value=''>&nbsp;</option>
						<option v-for="(supply,index) in suppliers" :value="supply.id">{{supply.name}}</option>
					</select>
					<label class="placeholder">{{$tc('suppliers',1)}}</label>
				</div>
				<div class="pad col-2">
					<button type="button" class="outline-orange" @click="showModal(CreateSupply,{afterSave:loadSuppliers})">{{$t('create')}}</button>
				</div>
			</div>
		</div>
		<div class="subtitle">{{$t('count')}}</div>
		<div class="d-flex">
			<div class="pad w-100">
				<input type="string" :placeholder="$t('quantity_items')" v-model="batch.items_no" required/>
				<label class="placeholder required"></label>
			</div>
			<div class="pad w-100">
				<input type="string" :placeholder="$t('quantity_titles')" v-model="batch.titles_no" required />
				<label class="placeholder required"></label>
			</div>
		</div>
		<div class="subtitle">{{$t('by_contract')}}</div>
		<div class="d-flex">
			<div class="pad w-100">
				<input type="string" :placeholder="$t('document_number')" v-model="batch.doc_no" required />
				<label class="placeholder required"></label>
			</div>
			<div class="pad w-100">
				<input type="string" :placeholder="$t('contract_number')" v-model="batch.contract_no"/>
				<label class="placeholder"></label>
			</div>
		</div>
		<div class="d-flex">
			<div class="pad w-100">
				<textarea :placeholder="$t('invoice_details')" v-model="batch.inv_details"/>
				<label class="placeholder"></label>
			</div>
			<div class="pad w-100 d-flex justify-content-end align-items-end">
				<div class="pad">
					<button type="submit">{{$t('save')}}</button>
				</div>
				<div class="pad">
					<button type="button" class="cancel-button" @click="cancel()">{{$t('cancel')}}</button>
				</div>
			</div>
		</div>
	</form>
</template>
<script type="text/javascript">
// identication in sublime text 3
import showModal from '../../../mixins/showModal'
import {last,getAllData} from '../../../mixins/common'

import CreateSupply from '../Supply/CreateSupply'
export default{
	mixins:[showModal,last,getAllData],
	props:{
		edit:Boolean,
		data:Object
	},
	data(){
		return{
			CreateSupply:CreateSupply,
			batch:{
				inv_date:null,
				items_no:null,
				titles_no:null,
				doc_no:null,
				sup_type:null,
				sup_id:null,
				contract_no:null,
				inv_details:null
			},
			suppliers:[]
		}
	},
	methods:{
		cancel(){
			this.$emit('close');
		},
		save(){
			if(!this.$store.state.fullPageLoading){
				this.$store.commit('setFullPageLoading',true);
				if(this.edit){
					this.batch.batch_id=this.data.id;
					this.editIt();
				}
				else{
					this.createIt();
				}
			}
		},
		editIt(){
			this.$http.put('/batch/update',this.batch).then(response=>{
				this.$store.commit('setFullPageLoading',false);
				try{
					this.afterSave(response.data.success.id);
				}catch(e){
					this.last('/batch','batches');
				}
				this.$fire({
					title:"Edit",
					text:messages.success(response),
					type:"success",
					timer:1700
				});
				this.$emit('close');
			}).catch(error=>{
				this.$store.commit('setFullPageLoading',false);
				this.$fire({
					title:"Edit",
					text:messages.error(error),
					type:"error",
				});
			});
		},
		createIt(){
			this.$http.post('/batch/create',this.batch).then(response=>{
				this.$store.commit('setFullPageLoading',false);
				this.getAllData('/batch','batches',10);
				this.$fire({
					title:"Save",
					text:messages.success(response),
					type:"success",
					timer:1700
				});
				this.$emit('close');
			}).catch(error=>{
				this.$store.commit('setFullPageLoading',false);
				this.$fire({
					title:"Create",
					text:messages.error(error),
					type:"error",
				});
			});	
		},
		loadSuppliers(value){
			this.batch.sup_id=value;
			this.$http.get('/supplier/names').then(response=>{
				this.suppliers=response.data.res;
			});
		}
	},
	created(){
		this.loadSuppliers();
		if(this.edit){
			this.batch=copy(this.data);
			this.batch.sup_type=copy(this.batch.sup_key);
			if(this.batch.inv_date){
				this.batch.inv_date=new Date(this.batch.inv_date).toDateInputValue();
			}
		}
	}
}
</script>
<style scoped>
.subtitle,.pad{
	margin-top:0.5em;
}
</style>
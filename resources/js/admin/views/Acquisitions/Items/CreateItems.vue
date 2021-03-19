<template>
	<form @submit.prevent="save()">
		<!-- this template is has 3 options in the same time : edit, create and recreate -->
		<div class="title mt-0">{{$t((edit ?'edit':reCreate ? 'reCreate':'create')+'_items') }}</div>
		<div class="d-flex">
			<div class="d-flex w-100">
				<div class="pad w-100">
					<input type="text" v-model="item.title" :disabled="edit || reCreate" :required="!(edit || reCreate)">
					<!-- it's required on create only  -->
					<label class="placeholder" :class="{required:!(edit || reCreate)}">{{$tc('titles',1)}}</label>
				</div>
			</div>
			<div class="d-flex w-100">
				<div class="pad w-100 select">
					<select v-model="item.batch_id" :required="!edit" :disabled="edit">
						<option value=''>&nbsp;</option>
						<option v-for="(batch,index) in batches" :value="batch.id">{{batch.id}}</option>
					</select>
					<label class="placeholder" :class="{required:!edit}">{{$t('batches_number')}}</label>
				</div>
				<div class="pad col-2" v-if="!edit">
					<button class="outline-orange" type="button" @click="showModal(CreateBatches,{afterSave:loadBatches})">{{$t('create')}}</button>
				</div>
			</div>
		</div>
		<div class="d-flex">
			<div class="d-flex w-100">
				<div class="pad w-100">
					<input type="text" v-model="item.author" :disabled="edit || reCreate" :required="!(edit || reCreate)"/>
					<label class="placeholder" :class="{required:!(edit || reCreate)}">{{$t('author')}}</label>
				</div>
			</div>
			<div class="d-flex w-100">
				<div class="pad w-100">
					<input type="text" v-model="item.isbn" :disabled="edit || reCreate" :required="!(edit || reCreate)">
					<label class="placeholder" :class="{required:!(edit || reCreate)}">{{$t('isbn')}}</label>
				</div>
			</div>
		</div>
		<div class="d-flex">
			<div class="d-flex w-100">
				<div class="pad w-100">
					<input type="text" v-model="item.pub_year" :disabled="edit" :required="!(edit )"/>
					<label class="placeholder" :class="{required:!(edit)}">{{$t('pub_year')}}</label>
				</div>
			</div>
			<div class="d-flex w-100">
				<div class="pad w-100 select">
					<select v-model="item.publisher_id" :disabled="edit" :required="!edit">
						<option value=''>&nbsp;</option>
						<option v-for="(publisher,index) in publishers" :value="publisher.id">{{publisher.name}}</option>
					</select>
					<label class="placeholder" :class="{required:!edit}">{{$tc('publishers',1)}}</label>
				</div>
				<div class="pad col-2" v-if="!edit">
					<button type="button" class="outline-orange" @click="showModal(CreatePublisher,{afterSave:loadPublishers})">{{$t('create')}}</button>
				</div>
			</div>
		</div>
		<div class="d-flex">
			<div class="d-flex w-100">
				<div class="pad w-100">
					<input type="text" v-model="item.pub_city" :disabled="edit" :required="!(edit)">
					<label class="placeholder" :class="{required:!(edit)}">{{$t('pub_city')}}</label>
				</div>
			</div>
			<div class="d-flex w-100">
				<div class="pad w-100 select">
					<select v-model="item.item_type" :required="!(edit || reCreate)" :disabled="edit || reCreate">
						<option value=''>&nbsp;</option>
						<option :value="item.type" v-if="(edit || reCreate)">{{item.type}}</option>
						<option v-for="(type,index) in support_data.types" :value="type.type_key">{{type.type}}</option>
					</select>
					<label class="placeholder" :class="{required:!(edit || reCreate)}">{{$t('type_of_item')}}</label>
				</div>
			</div>
		</div>
		<div class="d-flex">
			<div class="d-flex w-100">
				<div class="pad w-100">
					<input type="text" :required="!(edit)" v-model="(edit) ? null : item.count" :disabled="edit">
					<label class="placeholder" :class="{required:!(edit)}">{{$t('count')}}</label>
				</div>
				<div class="pad w-100">
					<input type="text" v-model="item.cost" required>
					<label class="placeholder required">{{$t('cost')}}</label>
				</div>
			</div>
			<div class="d-flex w-100">
				<div class="pad w-100 select">
					<select v-model="item.currency" required>
						<option value=''>&nbsp;</option>
						<option v-for="(currency,index) in support_data.currencies" :value="currency.currency">{{currency.currency}}</option>
					</select>
					<label class="placeholder required">{{$t('currency')}}</label>
				</div>
				<div class="pad w-100 select">
					<select v-model="item.location" required>
						<option value=''>&nbsp;</option>
						<option v-for="(location,index) in support_data.locations" :value="location.location_key">{{location.location}}</option>
					</select>
					<label class="placeholder required">{{$t('location')}}</label>
				</div>
			</div>
		</div>

		<div class="mt-5 d-flex justify-content-end">
			<div class="pad">
				<button type="submit">{{$t('save')}}</button>
			</div>
			<div class="pad">
				<button type="button" class="cancel-button" @click="cancel()">{{$t('cancel')}}</button>
			</div>
		</div>
	</form>
</template>
<script type="text/javascript">
// identication in sublime text 3
import showModal from '../../../mixins/showModal'
import {last,last_created,create_it,edit_it} from '../../../mixins/common'

import CreateBatches from '../Batches/CreateBatches'
import CreatePublisher from '../Publisher/CreatePublisher'
export default{
	mixins:[showModal,last,last_created,create_it,edit_it],
	props:{
		edit:Boolean,
		data:Object,
		afterSave:Function,
		reCreate:Boolean,
	},
	data(){
		return{
			CreateBatches:CreateBatches,
			CreatePublisher:CreatePublisher,
			item:{
				title:null,
				author:null,
				isbn:null,
				item_type:null,
				publisher_id:null,
				cost:null,
				user_cid:null,
				count:null,
				location:null,
				curredatancy:null
			},
			support_data:[],
			batches:[],
			publishers:[],
			link:'/item',
			commit:'items'
		}
	},
	methods:{
		cancel(){
			this.$emit('close');
		},
		save(){
			this.item.user_cid=this.$store.state.user.user_cid;
			if(!this.$store.state.fullPageLoading){
				this.$store.commit('setFullPageLoading',true);
				if(this.edit){
					this.editIt();
				}
				else{
					this.createIt();
				}
			}
		},
		editIt(){
			let item={
				inv_id:this.item.id,
				cost:this.item.cost,
				user_cid:this.item.user_cid,
				location:this.item.location,
				currency:this.item.currency
			};
			this.edit_it(this.link,this.commit,item,this.afterSave,this.last);
		},
		createIt(){
			let item={
				title:this.item.title,
				author:this.item.author,
				isbn:this.item.isbn,
				batch_id:this.item.batch_id,
				item_type:this.reCreate ? this.item.item_key : this.item.item_type,
				publisher_id:this.item.publisher_id,
				cost:this.item.cost,
				user_cid:this.item.user_cid,
				count:this.item.count,
				location:this.item.location,
				currency:this.item.currency,
				pub_city:this.item.pub_city,
				pub_year:this.item.pub_year
			};
			this.create_it(this.link,this.commit,item,this.afterSave,this.last_created);
		},
		loadBatches(value){
			this.item.batch_id=value;
			this.$http.get('/batch/numbers').then(response=>{
				this.batches=response.data.res;
			});
		},
		loadPublishers(value){
			this.item.publisher_id=value;
			this.$http.get('/publisher/names').then(response=>{
				this.publishers=response.data.res;
			});
		},
		loadSupportData(){
			this.$http.get(this.link+'/create-data').then(response=>{
				this.support_data=response.data.res;
				this.item.currency='KZT';
			});
		}
	},
	created(){
		this.loadBatches();
		this.loadPublishers();
		this.loadSupportData();

		if(this.edit || this.reCreate){
			this.item=copy(this.data);
			if(this.item.invoice_date){
				this.item.invoice_date=new Date(this.item.invoice_date).toDateInputValue();
			}
		}
	}
}
</script>
<style scoped>
.pad{
	margin-top: .5em;
}
</style>

<template>
	<div class="p-3">
		<div class="d-flex justify-content-between align-items-end">
			<div class="font-weight-bold">{{$t('item_filter')}}</div>
			<div class="text-grey cursor-pointer font-size-14" @click="reset('items')">{{$t('reset')}}</div>
		</div>
		<div class="overflow-scroll mt-3">
			<div class="text-grey font-size-12 font-weight-bold">{{$t('created_by')}}:</div>
			<div class="mt-2 select">
				<select v-model="search.add_options.user_cid">
					<option :value="null">None</option>
					<option v-for="(user,index) in support_data.users" :value="user.user_cid">{{user.username}}</option>
				</select>
			</div>
			<div class="text-grey font-size-12 font-weight-bold mt-3">{{$tc('suppliers',1)}}:</div>
			<input-div v-model="search.add_options.supplier_id" :selectable="{available:true,data:suppliers}" :head="'name'" :body="'id'" :autocomplete="{available:true,data:suppliers}" class="mt-2" />
			<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('type_of_supply')}}:</div>
			<div class="mt-2 select">
				<select v-model="search.add_options.sup_type">
					<option :value="null">None</option>
					<option value="D">Donated</option>
					<option value="B">Bought</option>
				</select>
			</div>
			<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('type_of_item')}}:</div>
			<div class="mt-2 select">
				<select v-model="search.add_options.item_type">
					<option :value="null">None</option>
					<option v-for="(type,index) in support_data.types" :value="type.item_type_key">{{type.item_type}}</option>
				</select>
			</div>
			<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('location')}}:</div>
			<div class="mt-2 select">
				<select v-model="search.add_options.location">
					<option :value="null">None</option>
					<option v-for="(type,index) in support_data.locations" :value="type.location_key">{{type.location}}</option>
				</select>
			</div>
			<div class="text-grey font-size-12 font-weight-bold mt-3">{{$tc('publishers',1)}}:</div>
			<input-div v-model="search.add_options.publisher_id" :selectable="{available:true,data:publishers}" :head="'name'" :body="'id'" :autocomplete="{available:true,data:publishers}" class="mt-2" />

			<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('pub_year')}}:</div>
			<div class="mt-2">
				<input type="text" v-model="search.add_options.pub_year">
			</div>
			<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('pub_city')}}:</div>
			<div class="mt-2">
				<input type="text" v-model="search.add_options.pub_city">
			</div>
			<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('fill_date')}}:</div>
			<div class="mt-2">
				<div class="position-relative">
					<input type="date" v-model="search.add_options.start_date">
					<label class="placeholder">{{$t('beginning')}}</label>
				</div>
				<div class="position-relative mt-2">
					<input type="date" v-model="search.add_options.end_date">
					<label class="placeholder">{{$t('end')}}</label>
				</div>
			</div>
			<div class="text-grey font-size-12 font-weight-bold mt-3">{{$t('cost')}}:</div>
			<div class="mt-2 mb-10">
				<input type="text" :placeholder="$t('from')" v-model="search.add_options.from_cost">
				<input class="mt-2" type="text" :placeholder="$t('until')" v-model="search.add_options.until_cost">
			</div>
		</div>
		<button class="outline-orange mt-3" type="submit">{{$t('save_&_search')}}</button>
	</div>
</template>
<script type="text/javascript">
// components
import InputDiv from '../../../components/common/Input'
//mixins 
import {reset} from '../../../mixins/common'

export default{
	mixins:[reset],
	components:{
		InputDiv
	},
	computed:{
		search(){
			return this.$store.getters.items.search;
		}
	},
	data(){
		return{
			support_data:{},
			suppliers:[],
			publishers:[]
		}
	},
	methods:{
		getSuppliers(){
			this.$http.get('/supplier/names').then(response=>{
				this.suppliers=response.data.res;
			})
		},
		getPublishers(){
			this.$http.get('/publisher/names').then(response=>{
				this.publishers=response.data.res;
			})
		},
		getSupportData(){
			this.$http.get('/item/create-data').then(response=>{
				this.support_data=response.data.res;
			})
		}
	},
	created(){
		this.getSuppliers();
		this.getPublishers();
		this.getSupportData();
	}
}
</script>
<style scoped>
.overflow-scroll{
	/*for overflow this HAS to be written hard*/
	max-height: 75vh;
}
</style>
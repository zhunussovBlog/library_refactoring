<template>
	<div class="d-flex">
		<div class="bg-white mt-2 w-100 p-2 px-3">
			<Back />
			<form @submit.prevent="loadResults()" class="mt-3">
				<div class="font-size-18 font-weight-bold">Search Barcodes</div>
				<div class="d-flex align-items-center w-100">
					<div class="text-no-wrap"> Choose search mode: </div>
					<Dropdown class="ml-2" :title="search.type" :items="['barcode','author-title']" :itemOnClick="changeMode" dropdownClasses="dropdown-left"/>
					<div class="d-flex align-items-center ml-2 w-100">
						<div class="d-flex w-100" v-if="search.type=='barcode'">
							<div class="pad w-100">
								<input type="text" v-model="search.first_barcode"/>
								<label class="placeholder">From</label>
							</div>
							<div class="pad w-100">
								<input type="text" v-model="search.last_barcode"/>
								<label class="placeholder">To</label>
							</div>
						</div>
						<div class="d-flex w-100" v-else>
							<div class="pad w-100">
								<input type="text" v-model="search.title"/>
								<label class="placeholder">Title</label>
							</div>
							<div class="pad w-100">
								<input type="text" v-model="search.author"/>
								<label class="placeholder">Author</label>
							</div>
						</div>
						<div class="pad">
							<button type="submit">{{$t('search')}}</button>
						</div>
						<div class="pad">
							<button type="button">Load all unprinted</button>
						</div>
					</div>
				</div>
			</form>
			<div class="mt-5">
				<div v-if="searching">
					<table-div class="mt-5" :heads="heads" :data="data.res" link="/report/barcode" commit="print_barcode" :sortable="false" :selectable="selectable" :pagination="false" :clickables="false"/>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
// components
import Back from '../../../components/common/Back'
import Dropdown from '../../../components/common/Dropdown'

// components
import Table from '../../../components/common/Table'

// loading indicator
import PulseLoader from 'vue-spinner/src/PulseLoader'

//mixins
import {getResults,reset} from '../../../mixins/common'

export default{
	mixins:[getResults,reset],
	components:{Back,Dropdown,'table-div':Table,PulseLoader},
	computed:{
		data(){
			return this.$store.getters.print_barcode.data;
		},
		searching(){
			return this.$store.getters.print_barcode.searching;
		}
	},
	data(){
		return{
			loading:false,
			types:[],
			search:{
				type:'barcode',
			},
			heads:[
			{name:'barcode',link:'barcode'},
			{name:'inventory_number',link:'inv_id'},
			{name:'titles',link:'title'},
			{name:'author',link:'author'},
			],
			selectable:{
				available:true,
				button_title:'print',
				func:this.printIt
			},
			barcodes:[]
		}
	},
	methods:{
		changeMode(mode){
			this.search.type=mode;
		},
		setLoading(bool){
			this.loading=bool;
		},
		setSearch(search){	
			this.search=search;
		},
		loadResults(){
			this.$store.dispatch('setStore',{label:'print_barcode',data:{page:0}});
			this.getResults(this.loading,this.setLoading,'/report/barcode',this.search,'print_barcode');
		},
		printIt(barcodes){
			console.log(barcodes);
			// this.$http.post('/report/barcode/print',{barcodes:barcodes}).then(response=>{
			// 	console.log(response);

				// simple pirnt implementation 

				// let w=window.open("www.url.com/pdf"); 
				// w.print(); 
				// w.close();
			// })
		}
	}
}
</script>
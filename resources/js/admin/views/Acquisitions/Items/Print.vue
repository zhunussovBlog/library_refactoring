<template>
	<div class="d-flex">
		<div class="bg-white mt-2 flex-fill p-2 px-3">
			<Back />
			<form @submit.prevent="loadResults()" class="mt-3">
				<div class="font-size-18 font-weight-bold">{{$t('search_barcodes')}}</div>
				<div class="d-flex align-items-center flex-fill">
					<div class="d-flex flex-column flex-fill">
						<span class="font-weight-bold mt-3">{{$t('barcode')}}</span>
						<div class="d-flex flex-fill mt-2">
							<div class="position-relative flex-fill">
								<input type="text" v-model="print_barcode.search.search_options[0].value.from"/>
								<label class="placeholder">{{$t('from')}}</label>
							</div>
							<div class="position-relative  ml-2 flex-fill">
								<input type="text" v-model="print_barcode.search.search_options[0].value.to"/>
								<label class="placeholder">{{$t('until')}}</label>
							</div>
						</div>
						<span class="font-weight-bold mt-3">{{$t('author-title')}}</span>
						<div class="d-flex flex-fill mt-2">
							<div class="position-relative flex-fill">
								<input type="text" v-model="print_barcode.search.search_options[1].value"/>
								<label class="placeholder">{{$t('title',1)}}</label>
							</div>
							<div class="position-relative ml-2 flex-fill">
								<input type="text" v-model="print_barcode.search.search_options[2].value"/>
								<label class="placeholder">{{$t('author')}}</label>
							</div>
						</div>
						<div class="mt-2 d-flex justify-content-end">
							<button class="width-unset" type="submit">{{$t('search')}}</button>
						</div>
					</div>
				</div>
			</form>
			<div class="mt-5">
				<div v-if="print_barcode.searching">
					<table-div class="mt-5"
					:heads="heads"
					:data="print_barcode.data.res"
					:selectable="selectable"
					:link="link"
					:commit="commit"
					:pagination="print_barcode.pagination"
					:clickables="false"
					:sortable="false"
					/>
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
import {getResults,download_file} from '../../../mixins/common'

import {mapGetters} from 'vuex'
export default{
	mixins:[getResults,download_file],
	components:{Back,Dropdown,'table-div':Table,PulseLoader},
	computed:{
		...mapGetters(['print_barcode'])
	},
	data(){
		return{
			types:[],
			type:'barcode',
			heads:[
			{name:'barcode',link:'barcode'},
			{name:'inventory_number',link:'id'},
			{name:'titles',link:'title'},
			{name:'author',link:'author'},
			],
			selectable:{
				available:true,
				button_title:'print',
				func:this.printIt
			},
			link:'/barcode',
			commit:'print_barcode',
			barcodes:[]
		}
	},
	methods:{
		changeMode(mode){
			this.type=mode;
		},
		loadResults(){
			this.$store.dispatch('setStore',{label:this.commit,data:{page:0}});
			this.getResults(this.link,this.commit);
		},
		printIt(barcodes){
			let inventories=barcodes.map(barcode=>barcode.id);
			this.$http.post(this.link+'/print',{inventories:inventories},{responseType:'blob'}).then(response=>{
				this.download_file(response,'media.pdf');
				this.$store.commit('setFullPageLoading',false);	
			})
		}
	}
}
</script>
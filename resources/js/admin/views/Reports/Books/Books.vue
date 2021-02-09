<template>
	<div class="bg-white pd-20">
		<div class="font-weight-500 font-size-15 pd-16 full-width text-center relative">
			<div>Most read books in the history of SDU</div>
			<!-- <div class="plus_wrapper cursor-pointer" @click="overallShown=!overallShown">
				<div class="plus_ver transition" :class="{minus:overallShown}"></div>
				<div class="plus_hor"></div>
			</div> -->
		</div>
		<div class="row flex-wrap mt-20">
			<div class="flex-1">
				<MRBChart />
			</div>
			<div class="flex-1 row ml-50">
				<div class="col">
					<div class="image"></div>
					<div class="text-center mt-20">Sherlock Holmes adventures</div>
				</div>
				<div class="ml-30 col justify-content-around">
					<div>Title</div>
					<div>Author</div>
					<div>ISBN</div>
					<div>Published city, year</div>
					<div>
						<button>See more info -></button>
					</div>
				</div>
			</div>
		</div>
		<div>
			<div class="pad font-weight-500 font-size-1125 mt-30 ">Search most read books</div>
			<div class="row align-items-center mt-10">
				<div class="full-width row">
					<div class="pad full-width">
						<input type="date" 	/>
						<label class="placeholder">From date</label>
					</div>
					<div class="pad full-width">
						<input type="date" 	/>
						<label class="placeholder">To date</label>
					</div>
				</div>
				<div class="align-items-center full-width">
					<div class="relative pad ml-20">
						<Dropdown title="Choose subject type" :items="['Any','Lorem Ipsum']" dropdownClasses="dropdown-left"/>
					</div>
					<div class="pad ml-auto">
						<button>Search</button>
					</div>
				</div>
			</div>
		</div>
		<div class="pad font-weight-500 font-size-15 mt-40 text-center">Search books</div>
		<div class="pad full-width align-items-center">
			<div>Mode: </div>&nbsp;
			<Dropdown :title="mode" :items="['Inventory number','history']" dropdownClasses="dropdown-left" :dropup="true" :itemOnClick="chooseMode" /> 
		</div>
		<div class="mt-10">
			<div v-if="mode=='history'"><History/></div>
			<div v-else><InventoryNumber/></div>
		</div>
	</div>
</template>
<script type="text/javascript">
// charts
import MRBChart from './MRBChart'
// components
import Dropdown from '../../../components/common/Dropdown'

import History from './History'
import InventoryNumber from './InventoryNumber'
export default {
	components:{Dropdown,History,InventoryNumber,MRBChart},
	data(){
		return{
			mode:'history'
		}
	},
	methods:{
		chooseMode(mode){
			this.mode=mode;
		}
	}
}		
</script>
<style scoped>
.image{
	width: 15em;
	height:20em;
	background-color: #9c9fa7;
	border-radius: 5px;
}
</style>
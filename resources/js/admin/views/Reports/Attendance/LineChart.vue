<template>
	<div class="full-width">
		<div class="align-items-center justify-content-between">
			<div class="align-items-center">
				<div class="font-weight-500 font-size-1125">Attendance statistics</div>
				<tabs class="ml-40" :components="components" :tabOnClick="chooseTab" tabClasses="mr-30 font-size-1125" />
			</div>
			<div class="row">
				<button type="button" class="bg-middle-gray color-black ">Export to Excel ?</button>
				<button type="button" class="bg-middle-gray color-black ml-10">Print</button>
			</div>
		</div>
		<div class="row mt-40">
			<div class="width-80">
				<line-chart :data="data" :options="withOptions(lineOptions)"/>
			</div>
			<div class="fifth ml-10">
				<dropdown dropdownClasses="dropdown-left full-width" titleClasses="border border-radius border-black pd-10 justify-content-center no-hover-color" :title="'Show for ' + (weekly?'week':'month')" :items="dropdownItems" :itemOnClick="dropdownItemOnClick"/>
				<div class="font-weight-500 mt-30">In library by {{weekly?'week':'month'}}</div>
				<div class="justify-content-between mt-20">
					<span>Students: </span>
					<span>{{studentsNumber}}</span>
				</div>
				<div class="justify-content-between mt-20">
					<span>Stuff: </span>
					<span>{{stuffNumber}}</span>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
// common components
import Tabs from '../../../components/common/Tabs'
import Dropdown from '../../../components/common/Dropdown'
// plugins / charts
import LineChart from '../../../plugins/charts/Line'
// mixins
import chartMixins from '../../../mixins/charts'
import {lineOptions} from '../../../mixins/charts'

export default{
	watch:{
		data(newValue,oldValue){
			this.setData();
			this.data=newValue;
		}
	},
	mixins:[chartMixins,lineOptions],
	components:{Tabs,LineChart,Dropdown},
	computed:{
		studentsNumber(){
			let num=0;
			return this.data.datasets[0].data.reduce((a, b) => a + b, 0)
		},
		stuffNumber(){
			let num=0;
			return this.data.datasets[1].data.reduce((a, b) => a + b, 0)
		}
	},
	data(){
		return{
			weekly:true,
			components:[{name:'Library'},{name:'Virtual'},{name:'Total'}],
			data:{
				datasets:[
				{
					label:'Students',
					data:[]
				},
				{
					label:'Stuff',
					data:[]
				}
				]
			},
			dropdownItems:[{name:'Week',value:true},{name:'Month',value:false}]
		}
	},
	methods:{
		changeData(){
			this.changeLabels();
			let num=0;
			if(this.weekly){
				num=7;
			}
			else{
				num=12;
			}
			let copied={};
			copied.datasets=this.data.datasets;
			copied.labels=this.data.labels;
			copied.datasets.forEach(set=>{
				let items=[];
				for(let i=0;i<num;i++){
					let j=Math.floor(Math.random()*50);
					items.push(j)
				}
				set.data=items;
			})
			this.data=copied;
		},
		chooseTab(tab){
			this.changeData();
		},
		changeLabels(){
			if(this.weekly){
				this.data.labels=this.weekLabels;
			}
			else{
				this.data.labels=this.monthLabels;
			}
		},
		dropdownItemOnClick(item){
			this.weekly=item.value;
			this.changeData();
		},
		setData(){
			this.data.datasets.forEach(item=>{
				if(item.label=="Students"){
					item.borderColor="#FF9D29"
				}
				else{
					item.borderColor="#9013FE"
				}
			})
		}
	},
	created(){
		this.setData();
	}
}
</script>

<template>
	<div class="w-100">
		<div class="d-flex align-items-center justify-content-between">
			<div class="font-weight-bold font-size-18">{{$t('attendance_statistics')}}</div>
		</div>
		<div class="d-flex mt-1">
			<div class="flex-fill">
				<line-chart :data="data" :options="withOptions(lineOptions)"/>
			</div>
			<div class="col-2 ml-2">
				<dropdown dropdownClasses="dropdown-left w-100" titleClasses="border rounded-lg border-black p-2 d-flex justify-content-center no-hover-color" :title="$t('show_for_' + ( weekly ? 'week' : 'month' ))" :items="dropdownItems" :itemOnClick="dropdownItemOnClick"/>
				<div class="font-weight-bold mt-4">{{$t('in_lib_by_' + (weekly ? 'week':'month'))}}</div>
				<div class="d-flex justify-content-between mt-3">
					<span>{{$t('student')}}: </span>
					<span>{{studentsNumber}}</span>
				</div>
				<div class="d-flex justify-content-between mt-3">
					<span>{{$t('employee')}}: </span>
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
import PieChart from '../../../plugins/charts/Pie'

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
			this.$http.get('/attendance/virtual').then(response=>{
				let copied={};
				let data=[];
				if(this.weekly){
					data=response.data.res.byWeek;
				}
				else{
					data=response.data.res.byMonth;
				}
				copied.datasets=this.data.datasets;
				copied.labels=this.data.labels;
				copied.datasets.forEach(set=>{
					if(set.label=='Students'){
						set.data=data.students;
					}
					else{
						set.data=data.employees;
					}
				})
				this.data=copied;
			})
			this.changeLabels();
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
		this.changeData();
	}
}
</script>

<template>
	<div class="pd-30">
		<div class="font-size-1125 font-weight-500">Overall attendance</div>
		<pie-chart class="mt-40" :data="data" :options="options" />
	</div>
</template>
<script type="text/javascript">
// plugins / charts
import PieChart from '../../../plugins/charts/Pie'
// mixins
import chartMixins from '../../../mixins/charts'

export default{
	mixins:[chartMixins],
	components:{PieChart},
	data(){
		return{
			data:{
				labels:['Students',"Stuff"],
				datasets:[
				{
					backgroundColor:["#FF9D29","#9013FE"],
					data:[]
				}
				]
			}
		}
	},
	methods:{
		changeData(){
			let num=2;
			let copied={};
			copied.datasets=this.data.datasets;
			copied.labels=this.data.labels;
			copied.datasets.forEach(set=>{
				let items=[];
				for(let i=0;i<num;i++){
					let j=Math.floor(Math.random()*500);
					items.push(j)
				}
				set.data=items;
			})
			this.data=copied;
		},
	},
	created(){
		this.changeData();
	}
}
</script>

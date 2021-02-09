<template>
	<div>
		<bar-chart :data="data" :options="withOptions(Object.assign({},lineOptions))" @click="onclick($event)"/>
	</div>
</template>
<script type="text/javascript">
// charts
import BarChart from '../../../plugins/charts/Line'
// mixins
import chartMixins from '../../../mixins/charts'
import {lineOptions} from '../../../mixins/charts'

export default{
	mixins:[chartMixins,lineOptions],
	components:{BarChart},
	data(){
		return {
			data: {
				labels: ['Sherlock Holmes adventures', 'Harry Potter and the prisoner of Azkaban','The lord of the rings','Lorem Ipsum','Dolor Sit Amet'],
				datasets: [
				{
					label:"Top 5",
					data: [80,60,55,36,20]
				}]
			},
		}
	},
	methods:{
		onclick(evt) {
			console.log(evt)
		}
	}
}
</script>
<template>
	<div class="col">
		<div class="row">
			<div class="ml-10 mt-10 bg-white border-radius width-80 pd-30">
				<line-chart />
			</div> 
			<div class="ml-10 mt-10 bg-white border-radius fifth mr-10">
				<pie-chart />
			</div>
		</div>
		<div class="ml-10 mt-10 bg-white border-radius mr-10 mb-10 pd-20 flex-1">
			<div class="font-weight-500 font-size-1125">Search attendance</div>
			<search class="mt-30" />
		</div>
	</div>
</template>
<script type="text/javascript">
// common components
import Tabs from '../../../components/common/Tabs'
import Dropdown from '../../../components/common/Dropdown'

// attendance components
import LineChart from './LineChart'
import PieChart from './PieChart'
import Search from './Search'

export default{
	components:{Tabs,Search,LineChart,PieChart,Dropdown},
}
</script>
<style scoped>
</style>
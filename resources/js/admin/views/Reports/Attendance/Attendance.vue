<template>
	<div class="col">
		<div class="d-flex">
			<div class="ml-2 mt-2 bg-white rounded-lg width-80 pd-30">
				<line-chart />
			</div> 
			<div class="ml-2 mt-2 bg-white rounded-lg col-2 mr-10">
				<pie-chart />
			</div>
		</div>
		<div class="ml-2 mt-2 bg-white rounded-lg mr-10 mb-10 pd-20 flex-1">
			<div class="font-weight-bold font-size-18">Search attendance</div>
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
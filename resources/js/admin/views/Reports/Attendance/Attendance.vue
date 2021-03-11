<template>
	<div>
		<div class="d-flex">
			<div class="m-2 bg-white rounded-lg w-100 p-4">
				<line-chart />
			</div> 
		</div>
	</div>
</template>
<script type="text/javascript">
// attendance components
import LineChart from './LineChart'

export default{
	components:{LineChart},
}
</script>

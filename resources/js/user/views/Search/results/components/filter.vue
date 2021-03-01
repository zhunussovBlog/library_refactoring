<template>
	<div class="filter-width bg-lightgrey p-3 rounded-lg">
		<div class="font-weight-bold">{{$t('filter')}}</div>
		<div class="text-grey font-size-14 mt-3">{{$t('types')}} :</div>
		<div class="d-flex justify-content-between mt-1">
			<div>Types</div>
			<div><checkbox /></div>
		</div>
		<div class="text-grey font-size-14 mt-3">{{$t('languages')}} :</div>
		<div class="d-flex justify-content-between mt-1">
			<div>Languages</div>
			<div><checkbox /></div>
		</div>
		<div class="d-flex justify-content-between mt-1">
			<div>Types</div>
			<div><checkbox /></div>
		</div>
		<div class="text-grey font-size-14 mt-3">{{$t('year')}} :</div>
		<div class="mt-1">
			<select-div class="p-2 bg-white" :data="data" />
		</div>
		<button class="mt-3 w-100 bg-white text-orange">{{$t('apply')}}</button>
	</div>
</template>
<script type="text/javascript">
	import SelectDiv from '../../../../components/select'
	import Checkbox from '../../../../components/checkbox'
	export default{
		components:{
			SelectDiv,
			Checkbox
		},
		data(){
			return{
				data:[1,2,3,4,5]
			}
		}
	}
</script>

<template>
	<form class="position-relative">
		<select-div :data="select_data" class="w-20 w-min-120 p-3 border-grey no-border-right no-border-right-radius border-width bg-white"/>
		<div id="warn-simple" class="warn">{{$t('at_least_2')}}</div>
		<autocomplete class="w-100 mr--5" input_classes="rounded-0 border-grey" />
		<button type="submit" class="border-grey w-min-120">{{$t('search')}}</button>
	</form>
</template>
<script type="text/javascript">
	import SelectDiv from '../../../../../components/select'
	import autocomplete from '../../components/autocomplete'
	export default{
		components:{
			SelectDiv,
			autocomplete
		},
		data(){
			return{
				select_data:[1,2,3]
			}
		}
	}
</script>

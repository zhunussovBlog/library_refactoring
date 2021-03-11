<template>
	<div class="mt-2 bg-white py-4 px-3">
		<div class="align-items-center">
			<Back />
			<span class="ml-4 font-size-18 text-grey">Serving: &nbsp;</span>
			<span class="font-size-18">{{info.name+' '+info.surname}}</span>
		</div>
		<div class="height-1 w-100 mt-3"></div>
		<div class="mt-3">
			<span class="font-size-20 font-weight-bold">Books to be given</span>
			<table-div :selectable="selectable" :sortable="false" :pagination="false" :clickables="false"></table-div>
		</div>
	</div>
</template>
<script type="text/javascript">
// components
import Back from '../../../components/common/Back'
import Table from '../../../components/common/Table'

// mixins
import {goTo} from '../../../mixins/goTo'
export default{
	mixins:[goTo],
	components:{Back,'table-div':Table},
	data(){
		return{
			selectable:{available:true,button_title:'check_in'}
		}
	},
	created(){
		this.info={};
	}
}
</script>
<style scoped>
.height-1{
	background-color: #E8E8E8;
}
</style>
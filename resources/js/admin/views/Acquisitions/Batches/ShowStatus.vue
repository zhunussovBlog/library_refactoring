<template>
	<div>
		<table>
			<tr class="border-bottom">
				<th>{{$t('types')}}</th>
				<th>{{$t('filled_in')}}</th>
				<th>{{$t('made_actually')}}</th>
				<th>{{$t('correct')}}</th>
			</tr>
			<tr>
				<td>{{$t('quantity_titles')}}</td>
				<td>{{data.titles_no}}</td>
				<td>{{data.titles_ma}}</td>
				<td>{{data.titles_no == data.titles_ma ? $t('yes') : $t('no')}}</td>
			</tr>
			<tr class="border-bottom">
				<td>{{$t('quantity_items')}}</td>
				<td>{{data.items_no}}</td>
				<td>{{data.items_ma}}</td>
				<td>{{data.items_no == data.items_ma ? $t('yes') : $t('no')}}</td>
			</tr>
		</table>
		<div class="d-flex justify-content-between align-items-center pt-2">
			<div class="text-red">
				<div v-if="data.titles_no != data.titles_ma">
					<span><Warning /></span>
					<span class="ml-1">
						{{$t('titles_no_match')}}
					</span>
				</div>
				<div class="mt-1" v-if="data.items_no != data.items_ma">
					<span><Warning /></span>
					<span class="ml-1">
						{{$t('items_no_match')}}
					</span>
				</div>
			</div>
			<div class="pad">
				<button type="button" class="outline-black" @click="$emit('close')">{{$t('ok')}}</button>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
// icons
import Warning from '../../../assets/icons/Warning'
export default{
	components:{Warning},
	props:{
		id:String
	},
	data(){
		return{
			data:{}
		}
	},
	methods:{
		getStatuses(){
			this.$http.get('/batch/status/'+this.id).then(response=>{
				this.data=response.data.res;
			})
		}
	},
	created(){
	this.getStatuses();	
	}
}
</script>
<style scoped>
table {
	width: 100%;
}

td, th {
	padding: 1em 0;
}

th{
	text-align: left;
	color:#9C9FA7;
	font-weight: 500;
}

.border-bottom >td,th{
	border-bottom: 0.0625em solid #E8E8E8;
}

</style>
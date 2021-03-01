<template>
	<form class="flex-column">
		<div class="d-flex position-relative mb-2" v-for="(input,index) in inputs" :key="index">
			<div :id="'warn-'+index" class="warn">{{$t('at_least_2')}}</div>
			<select-div :data="select_data" class="w-20 w-min-120 p-3 border-grey no-border-right no-border-right-radius border-width bg-white"/>
			<autocomplete class="w-100 mr-3" input_classes="no-border-left-radius border-grey" />
			<button type="button" class="w-min-120 ml-20" @click="addItem()" v-if="!(index < (inputs.length-1)) && (index < maximum-1)"> + </button>
			<select-div :data="operations" class="w-min-120 border-grey border-width bg-white p-3 " v-else></select-div>
		</div>
		<div class="d-flex justify-content-between flex-wrap mt-3">
			<button type="button" @click="clear()">{{$t('reset')}}</button>
			<button type="submit" >{{$t('search')}}</button>
		</div>
	</form>
</template>
<script type="text/javascript">
	import SelectDiv from '../../../../../components/select'
	import autocomplete from '../../components/autocomplete'
	export default{
		props:{
			maximum:{
				type:Number,
				default(){
					return 5
				}
			}
		},
		components:{
			SelectDiv,
			autocomplete
		},
		data(){
			return{
				select_data:[1,2,3],
				operations:['and','or','not'],
				inputs:[{search:{}},{search:{},operator:'and'}]
			}
		},
		methods:{
			addItem(){
				if(this.inputs.length<this.maximum){
					this.inputs.push({search:{},operator:'and'});
				}
			},
			clear(){
				this.inputs=[{search:{}},{search:{},operator:'and'}];
			},
		}
	}
</script>
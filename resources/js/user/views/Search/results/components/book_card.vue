<template>
	<div class="d-flex border-top py-3">
		<div class="mr-5">
			<checkbox />
			<div class="image rounded bg-grey mt-3" :style="'background-image: url('+this.image+')'">IMAGE</div>
		</div>
		<div class="flex-grow-1">
			<div class="d-flex text-center text-blue">
				<div class="rounded-lg bg-lightblue p-1 px-3 ">Type</div>
				<div class="rounded-lg bg-lightblue p-1 px-3 ml-3">Call number</div>
			</div>
			<div class="mt-3 overflow-hidden title font-weight-bold font-size-24" style="">titlteti kdafj l;akj f adsj fasdl;kfj a;ldk</div>
			<div class="text-grey mt-2">
				<div>Author</div>
				<div>Publisher</div>
				<div>Year</div>
			</div>
		</div>
		<div class="text-center col-2 px-0">
			<div class="bg-lightgrey rounded-lg p-2 text-no-wrap">
				{{$t('available',{num:0})}}
			</div>
			<button class="bg-white border border-grey text-grey px-0 w-100 mt-4">{{$t('show_details')}}</button>
		</div>
	</div>
</template>
<script type="text/javascript">
	import Checkbox from '../../../../components/checkbox'
	export default{
		components:{
			Checkbox
		},
		data(){
			return{
				image:''
			}
		}
	}
</script>
<style scoped>
.image{
	min-width:8.75em;
	max-width:8.75em;
	min-height:10em;
	max-height:10em;
	background-size: 100% 100%;
}
.title{
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	text-overflow: ellipsis;
}
</style>
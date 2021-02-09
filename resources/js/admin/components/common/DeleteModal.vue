<template>
	<div class="col align-items-center justify-content-center">
		<div class="font-weight-500">{{$t('confirmation')}}</div>
		<div class="justify-content-between mt-5">
			<button type="button" class="outline-red" @click="deleteIt()">{{$t('yes')}}</button>
			<button type="button" class="outline-black ml-5" @click="$emit('close')">{{$t('no')}}</button>
		</div>
	</div>
</template>
<script type="text/javascript">
// identication in sublime text3
import {last} from '../../mixins/common'
export default{
	props:{link:String,commit:String,id:String,afterDelete:Function},
	mixins:[last],
	methods:{
		deleteIt(){
			this.$http.delete(this.link+'/delete/'+this.id).then(response=>{
				this.last(this.link,this.commit);
				try{
					this.afterDelete();
				}catch(e){}
				this.$fire({
					title:"Delete",
					text:messages.success(response),
					type:"success",
					timer:1700
				});
				this.$emit('close');
			}).catch(error=>{
				this.$fire({
					title:"Delete",
					text:messages.error(error),
					type:"error"
				});
				this.$emit('close');
			})
		}
	}
}
</script>
<style scoped>
.row{
	width:30%;
}
</style>
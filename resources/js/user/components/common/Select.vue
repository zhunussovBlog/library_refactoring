<template>
	<div tabindex="0" class="select border pd-10-20 align-items-center border-box" @focusout="num=0;show()">
		<div class="justify-content-between cursor-pointer full-width" @click="showIt()">
			<label>{{value ? (label ? $t(value[label]) : $t(value)) : (defaultAll ? $t('all') : data.length>0 ? (label ? $t(data[0][label]) : $t(data[0])) : '')}}</label>
			&nbsp;
			<div class="rotate justify-content-center align-items-center"><CaretUp/></div>
		</div>
		<div ref="select" class="results bg-white shadowed border-box pl-18 transition">
			<div class="ptb-10 border-bottom border-box cursor-pointer" @click="onClick('')" v-if="defaultAll">{{$t('all')}}</div>
			<div class="ptb-10 border-bottom border-box cursor-pointer" v-for="(info,index) in data" :key="index" @click="onClick(info)">{{label ? $t(info[label]) : $t(info)}}</div>
		</div>
	</div>
</template>
<script type="text/javascript">
// icons
import CaretUp from '../../assets/icons/CaretUp'

export default{
	model:{
		event:'change',
		prop:'value'
	},
	props:{
		value:[Object,String],
		data:Array,
		placeholder:String,
		// label - what is shown as an option
		label:String,
		// if there's an option to choose all
		defaultAll:Boolean,
		disabled:Boolean,
	},
	components:{CaretUp},
	data(){
		return{
			num:0
		}
	},
	methods:{
		show(){
			let doc=this.$refs.select;
			doc.style.maxHeight=this.num+'px';
		},
		showIt(){
			if(!this.disabled){
				if(this.num==0){
					let doc=this.$refs.select;
					this.num=(window.innerHeight-(doc.getBoundingClientRect().bottom))>250 ? 250 : (window.innerHeight-doc.getBoundingClientRect().bottom) ;
				}
				else{
					this.num=0;
				}
				this.show();
			}
		},
		onClick(info){
			if(!this.disabled){
				this.$emit('change',info);
				this.num=0;
				this.show();
			}
		}
	},
	created(){
		if(!this.value){
			try{
				this.$emit('change',data[0]);
			}catch(e){}
		}
	}
}
</script>
<style scpoed>
.transition{
	transition: .3s;
}
.select{
	position: relative;
	border-radius: 0.3125em;
}
.results{
	position: absolute;
	top:102%;
	width: 100%;
	left:0;
	z-index: 1000;
	overflow: hidden;
	overflow-y:auto;
	max-height: 0;
}
</style>
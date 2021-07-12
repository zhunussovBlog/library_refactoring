<template>
	<div class="position-relative h-100"  @submit.prevent="submitTotal" tabindex="1" @focusout="shown=false">
		<form class="position-relative h-100">
			<input type="text" class="pl-3" :class="classes" v-model="text" @input="onInput()" :placeholder="placeholder"  />
			<span v-if="selectable.available" class="d-flex align-items-center icon cursor-pointer selectable">
				<span @click="showList()">
					<CaretUp class="down" />
				</span>
			</span>
			<span v-if="search" class="d-flex align-items-center icon cursor-pointer">
				<span @click="reset" v-if="value">
					<Cancel />
				</span>
				<span @click="submitTotal" v-else>
					<Search/>
				</span>
			</span>
		</form>
		<div class="results" :class="{'shown bordered':shown}">
			<div class="result text-ellipsis" :class="{no_border_bottom:index==results.length-1}" v-for="(result,index) in results" :key="index" @click="select(result)">{{$t(result[head])}}</div>
		</div>
	</div>
</template>
<script type="text/javascript">
// identication in sublime 3
// icons
import Search from '../../common/assets/icons/Search'
import Cancel from '../../common/assets/icons/Cancel'
import CaretUp from '../../common/assets/icons/CaretUp'
export default{
	model: {
		prop: 'value',
		event: 'input'
	},
	components:{Search,Cancel,CaretUp},
	props:{
		placeholder:{
			type:String,
			default(){return ''}
		},
		search:{
			type:Boolean,
			default(){
				return false
			}
		},
		autocomplete:{
			type:Object,
			default(){
				return {available:false}
			}
		},
		selectable:{
			type:Object,
			default(){
				return {available:false}
			}
		},
		head:String,
		body:String,
		value:{
			type:[Object,String,Number,Boolean],
			default(){
				return null
			}
		},
		disabled:{
			type:Boolean,
			default(){
				return false
			}
		},
		onSubmit:{
			type:Function,
			default(){
				return null
			}
		},
		afterSubmit:{
			type:Function,
			default(){
				return null
			}
		},
		classes:{
			type:[Array,String]
		},
		showBody:{
			type:Boolean,
			default:true
		}
	},
	watch:{
		'value'(newValue){
			this.setText(newValue);
		}
	},
	data(){
		return{
			text:'',
			shown:false,
			results:[0],
			result:{}
		}
	},
	methods:{
		submitTotal(){
			if(!this.disabled){
				if(this.onSubmit!=null){
					this.onSubmit();
				}
				try{
					this.afterSubmit()
				}catch(e){}
			}
		},
		onInput(){
			if(this.autocomplete.available){
				let data=copy(this.autocomplete.data);
				this.results=data.filter((item)=>{
					return item[this.head].toLowerCase().includes(this.text.toLowerCase())
				}).splice(0,200);
				this.shown=true;
			}
			this.$emit('input',this.text);
		},
		showList(){
			let data=copy(this.selectable.data);
			this.results=data.splice(0,200);
			this.show();
		},
		show(){
			this.shown=!this.shown;
		},
		select(result){
			let res=result[this.body];
			this.$emit('input',res);
			this.setText(res);
			this.shown=false;
		},
		reset(){
			this.$emit('input','');
		},
		setText(value){
			if(this.selectable.available){
				let result = this.selectable.data.filter(item=>item[this.body]==value);
				if(result.length > 0){
					this.text = result[0][this.head]
					if(this.showBody){
						this.text += ' (' + result[0][this.body] + ')';
					}
				}
				else{
					this.text=value;
				}
			}
			else{
				this.text=value;
			}
		}
	},
	created(){
		this.setText(this.value);
	}
}
</script>
<style scoped>
input{
	padding:unset;
}
.icon{
	font-size: 1.2em;
	position: absolute;
	top:0;
	height:100%;
	right:1.25em;
}
.selectable{
	/*hard..*/	
	right: .86em;
}
.padding-right{
	padding-right: 2.3em !important;
}
.down{
	transform: rotate(180deg);
}
.results{
	position: absolute;
	top:110%;
	width: 100%;
	background:white;
	overflow:auto;
	transition: .3s;
	border-radius: .3125em;
	z-index: 998;
	max-height: 0em;
}
.shown{
	max-height: 20em;
}
.result{
	padding:.4em .625em;
	border-bottom:.03125em solid #B5BAC7;
	cursor: pointer;
}
.bordered{
	border:0.03125em solid #B5BAC7;
}
.result:hover{
	background-color:rgba(100,100,100,0.1);
	color:#FF9D29;
}
.no_border_bottom{
	border-bottom: none;
}
</style>
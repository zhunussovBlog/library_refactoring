<template>
	<div class="position-relative flex-fill"  @submit.prevent="submitTotal" tabindex="1" @focusout="shown=false">
		<form class="position-relative h-100">
			<input type="text" class="padding-right" :class="classes" v-model="text" @input="onInput()" :placeholder="placeholder"  />
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
		<div class="results" :class="{shown:shown}">
			<div class="result text-ellipsis" :class="{no_border_bottom:index==results.length-1}" v-for="(result,index) in results" @click="select(result)">{{$t(result[head])}}</div>
		</div>
	</div>
</template>
<script type="text/javascript">
// identication in sublime 3
// icons
import Search from '../../assets/icons/Search'
import Cancel from '../../assets/icons/Cancel'
import CaretUp from '../../assets/icons/CaretUp'
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
		}
	},
	watch:{
		'value'(newValue,oldValue){
			if(this.selectable.available){
				let result=this.selectable.data.filter(item=>{
					return item[this.body]==newValue
				});
				if(result.length>0){
					this.text=result[0][this.head] + ' (' + result[0][this.body] + ')';
				}
				else{
					this.text=newValue;
				}
			}
			else{
				this.text=newValue;
			}
		}
	},
	data(){
		return{
			text:this.value ?? '',
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
			this.text=result[this.head] + ' (' + res + ')';
			this.$emit('input',res);
			this.show();
		},
		reset(){
			this.$emit('input','');
		}
	}
}
</script>
<style scoped>
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
	padding-right: 2.3em;
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
	border:0.03125em solid transparent;
	border-radius: .3125em;
	z-index: 1;
	max-height: 0em;
}
.shown{
	max-height: 20em;
	border-color: #B5BAC7;
}
.result{
	padding:.4em .625em;
	border-bottom:.03125em solid #B5BAC7;
	cursor: pointer;
}
.result:hover{
	background-color:rgba(100,100,100,0.1);
	color:#FF9D29;
}
.no_border_bottom{
	border-bottom: none;
}
</style>
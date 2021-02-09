<template>
	<div ref="slide_items" class="relative align-items-center min-width-none">
		<div class="full-width overflow-hidden">
			<div ref="items" class="justify-content-between transition">
				<div v-for="(item,index) in items" class="bg-light-gray border-radius no-shrink transition" :class="index==items.length-1 ? 'ml-10' : 'mr-10'" :style="{width:itemWidth+ 'px'}">
					<div class="row pd-20">
						<div class="mr-40 col">
							<span class="font-size-2">DAY</span>
							<span class="mt-10">Month</span>
						</div>
						<div class="color-gray font-size-0875 col justify-content-around">
							<div>The place</div>
							<div>Time</div>
						</div>
					</div>
					<div class="bg-gray mlr-20 height-1"></div>
					<div class="pd-20 font-weight-500 font-size-125"> That's the event's name</div>
				</div>
			</div>
		</div>
		<div class="left_button rotate cursor-pointer" @click="move(-1)" v-if="current_item!=0">
			<RightLittle />
		</div>
		<div class="right_button cursor-pointer" @click="move(1)" v-if="current_item!=(items.length-this.number)">
			<RightLittle />
		</div>
	</div>
</template>
<script type="text/javascript">
// identication in sublime text 3
// icons
import RightLittle from '../../assets/icons/RightLittle'

export default{
	props:{
		items:{
			type:Array,
			default(){
				return [1,2,3,4,5]
			}
		},
		number:{
			type:[Number,String],
			default(){
				return 3
			}
		}
	},
	components:{
		RightLittle
	},
	data(){
		return{
			current_item:0,
			itemWidth:'300'
		}
	},
	methods:{
		move(num){
			let parent=this.$refs['slide_items'];
			let items = this.$refs['items'];
			if((this.current_item+num)>=0 && (this.current_item+num+this.number)<=this.items.length){
				this.current_item+=num;
				items.style.transform="translateX("+(-this.current_item*this.itemWidth + (-this.current_item*10)) +'px) translateY(0px)';
			}
		},
		changeItemWidth(){
			setTimeout(()=>{
				let parent=this.$refs['slide_items'];
				this.itemWidth=((parent.offsetWidth - (this.number-1)*10))/this.number;
			},300)
		},
		resize(){
			this.changeItemWidth();
			setTimeout(()=>{
				this.move(0);
			},310)
		}
	},
	beforeMount(){
		window.addEventListener("resize", this.resize);
		this.changeItemWidth();
	},
	destroyed() {
		window.removeEventListener("resize", this.resize);
	}
}
</script>
<style scoped>
.right_button,.left_button{
	position: absolute;
	width:3em;
	height:3em;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	background-color: white;
	box-shadow: 0 0.125em 0.625em rgba(141, 155, 164, 0.32);
}
.right_button{
	right:-1.5em;
}
.left_button{
	left:-1.5em;
}
</style>
<template>
	<div ref="slide_items" class="relative align-items-center min-width-none">
		<div class="full-width overflow-hidden" :class="{scroll:$mobileCheck()}">
			<div ref="items" class="justify-content-between transition">
				<div v-for="(item,index) in items" class="bg-white border border-blue border-radius no-shrink transition" :class="{'mr-10':!(index==items.length-1)}" :style="{width:itemWidth+ 'px'}">
					<div class="color-blue pd-20">Library Orientation</div>
					<div class="bg-blue height-1 mlr-20" />
					<div class="pd-20 row">
						<div class="play_button mr-20 bg-orange color-white">
							<Play />
						</div>
						<div>Are you a new student/ professor at SDU? Watch this video!</div>
					</div>
				</div>
			</div>
		</div>
		<div class="left_button rotate cursor-pointer" @click="move(-1)" v-if="current_item!=0 && !$mobileCheck()">
			<RightLittle />
		</div>
		<div class="right_button cursor-pointer" @click="move(1)" v-if="current_item!=(items.length-this.number) && !$mobileCheck()">
			<RightLittle />
		</div>
	</div>
</template>
<script type="text/javascript">
// identication in sublime text 3
// icons
import RightLittle from '../../assets/icons/RightLittle'
import Play from '../../assets/icons/Play'

export default{
	props:{
		items:{
			type:Array,
			default(){
				return [1,2,3,4,5]
			}
		},
		max_number:{
			type:[Number,String],
			default(){
				return 2			
			}
		}
	},
	components:{
		RightLittle,
		Play
	},
	data(){
		return{
			current_item:0,
			itemWidth:'300',
			number:0,
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
				let number=window.innerWidth>1000 ? (this.max_number >= 3 ? (window.innerWidth>1420 ? this.max_number : 2) : this.max_number ):1;
				this.itemWidth=((parent.offsetWidth - 1 - (number-1)*10)/number);
				this.number=number;
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
.play_button{
	min-width: 2.5em;
	max-width: 2.5em;
	min-height: 2.5em;
	max-height: 2.5em;
	border-radius:50%;
	display: flex;
	justify-content: center;
	align-items: center;
}
.scroll{
	overflow: auto;
}

/*firefox only*/
* {
	scrollbar-width:none;
}

/*crossbrowser*/
::-webkit-scrollbar {
  width: 0;
  height: 0;
}

</style>
<template>
	<div ref="parent" class="parent bg-white transition hoverable">
		<div class="align-items-center cursor-pointer full-height" @click="showChat()" v-if="!chatShown">
			<span class="color-orange font-size-15 justify-content-center align-items-center no-shrink transition">
				<component :is="Chat"/>
			</span>
			<span refs="ask" class="mr-20 text-no-wrap ml-20">{{$t('ask_librarian')}}</span>
		</div>
		<div v-else>
			<div class="pd-30 justify-content-between">
				<div class="font-weight-500">{{$t('chat_librarian')}}</div>
				<div @click="close()" class="cursor-pointer"><Times /></div>
			</div>
			<div class="height-1 full-width bg-light-gray" />
		</div>
	</div>
</template>
<script type="text/javascript">
// icons
import Chat from '../../assets/icons/Chat'
import Times from '../../assets/icons/Times'

export default{
	components:{
		Times
	},
	data(){
		return{
			Chat:Chat,
			chatShown:false
		}
	},
	methods:{
		showChat(){
			this.chatShown=true;
			this.$refs['parent'].classList.remove('hoverable');
			this.$refs['parent'].classList.add('chat');
		},
		close(){
			this.chatShown=false;
			this.$refs['parent'].classList.remove('chat');
			setTimeout(()=>{
				this.$refs['parent'].classList.add('hoverable');
			},400);
		}
	}
}	
</script>
<style scoped>
.parent{
	position: fixed;
	bottom:3.125em;
	right:3.125em;
	z-index: 2;
	max-width: 3.75em;
	height:3.75em;
	overflow: hidden;
	border-radius: 3.125em;
	box-shadow: 0 0.25em 0.625em rgba(141, 155, 164, 0.6);
	width:3.75em;
}
.hoverable{
	width:unset;
}
.hoverable:hover{
	max-width: 18em;
	width:unset;
}
.hoverable:hover .chat_icon{
	transform:rotate(-360deg);
	background-color: #ff9d29;
	color:white;
}
.chat_icon{
	width: 2.5em;
	height:2.5em;
	border-radius: 3.125em;
}

.chat{
	height: 28.125em;
	width: 25em;
	background-color: white;
	border-radius: 0;
	border-top-right-radius: 1.875em;
	border-top-left-radius: 1.875em;
	box-shadow: 0 0.25em 1.875em rgba(141, 155, 164, 0.6);
	max-width: 62.5em;
}
.pd-30{
	padding:1.875em;
}
.close{
	max-width: 3.75em;
}
.hidden{
	display: none;
}
</style>
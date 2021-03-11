<template>
	<form @submit.prevent="save()">
		<div class="title">{{$t((edit ?'edit':'create')+'_publisher') }}</div>
		
		<div class="d-flex">
			<div class="pad">
				<input type="string" :placeholder="$t('name')" v-model="publisher.name" required />
				<label class="placeholder required"></label>
			</div>
			<div class="pad">
				<input type="string" :placeholder="$t('commercial_name')" v-model="publisher.com_name"/>
			</div>
		</div>
		<div class="subtitle">{{$t('contact')}}</div>
		<div class="d-flex">
			<div class="pad">
				<input type="string" :placeholder="$t('address')" v-model="publisher.address"/>
			</div>
			<div class="pad">
				<input type="string" :placeholder="$t('email')" v-model="publisher.email"/>
			</div>
		</div>
		<div class="d-flex">
			<div class="pad">
				<input type="string" :placeholder="$t('phone')" v-model="publisher.phone"/>
			</div>
			<div class="pad">
				<input type="string" :placeholder="$t('fax')" v-model="publisher.fax"/>
			</div>
		</div>
		<div class="justify-content-end">
			<div class="pad">
				<button type="submit">{{$t('save')}}</button>
			</div>
			<div class="pad">
				<button type="button" class="cancel-button" @click="cancel">{{$t('cancel')}}</button>
			</div>
		</div>
	</form>
</template>
<script type="text/javascript">
// mixins
import {last,getAllData} from '../../../mixins/common'

export default{
	mixins:[last,getAllData],
	props:{
		edit:Boolean,
		data:Object,
		afterSave:Function,
	},
	data(){
		return{
			publisher:{
				name:null,
				com_name:null,
				address:null,
				email:null,
				phone:null,
				fax:null
			}
		}
	},
	methods:{
		save(){
			if(!this.$store.state.fullPageLoading){
				this.publisher.pub_name=this.publisher.name;
				this.$store.commit('setFullPageLoading',true);
				if(this.edit){
					this.publisher.pub_id=this.data.id;
					this.editIt();
				}
				else{
					this.createIt();
				}
			}
		},
		cancel(){
			this.$emit('close');
		},
		editIt(){
			this.$http.put('/publisher/update',this.publisher).then(response=>{
				this.$store.commit('setFullPageLoading',false);
				this.last('/publisher','publishers');
				this.$fire({
					title:"Edit",
					text:messages.success(response),
					type:"success",
					timer:1700
				});
				this.$emit('close');
			}).catch(error=>{
				this.$store.commit('setFullPageLoading',false);
				this.$fire({
					title:"Edit",
					text:messages.error(error),
					type:"error"
				});
			})
		},
		createIt(){
			this.$http.post('/publisher/create',this.publisher).then(response=>{
				try{
					this.afterSave(response.data.success.id);
				}catch(e){
					this.getAllData('/publisher','publishers',10);
				}
				this.$store.commit('setFullPageLoading',false);
				this.$fire({
					title:"Create",
					text:messages.success(response),
					type:"success",
					timer:1700
				});
				this.$emit('close');
			}).catch(error=>{
				this.$store.commit('setFullPageLoading',false);
				this.$fire({
					title:"Create",
					text:messages.error(error),
					type:"error"
				});
			})
		}
	},
	created(){
		if(this.edit){
			this.publisher=copy(this.data);
		}
	}
}
</script>
<style scoped>
.d-flex>div{
	width:100%;
}
.pad{
	mt-5:1em;
}
</style>
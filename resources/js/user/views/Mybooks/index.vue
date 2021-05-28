<template>
  <div class="padding mt-5">
      <div class="mt-3 font-size-32 font-weight-bold">
          {{$t('my_books')}}
      </div>
      <div class="d-flex justify-content-between mt-3">
          <div class="d-flex flex-column">
              <div class="bg-lightgrey rounded p-3">
                  <div class="image imageWidth imageHeight" :style="'background-image: url('+backgroundImage+')'"></div>
              </div>
              <div class="py-2 mt-auto bg-green d-flex flex-column align-items-center rounded-lg">
					<div class="imageWidth d-flex justify-content-between text-white" v-for="(value,key,index) in user.total" :key="index">
						<div>
							{{$t(key)+":"}}
						</div>
						<div>
							{{value}}
						</div>
					</div>
				</div>
          </div>
          <div class="bg-lightgrey rounded-lg p-3 ml-4 flex-fill" v-if='user.info'>
				<div class="d-flex" :class="{'mt-4':index!=0}" v-for="(value,key,index) in user.info" :key="index">
					<div class="text-grey">{{capitalize($t(key))}}:</div>
					<div class="ml-2">{{value}}</div>
					&nbsp;
				</div>
			</div>
      </div>
      <table class="table my-5">
          <thead>
              <tr class="text-grey">
                  <th class="header text-center bg-lightgrey" v-for="(item, index) in heads" :key="index">
                      {{$t(item)}}
                  </th>
              </tr>
          </thead>
          <tbody>
              <tr v-for="(item,index) in data" :key="index">
                  <td class="text-center" v-for="(name,index) in heads" :key="index">
                      {{item[name]}}
                  </td>
              </tr>
          </tbody>
      </table>
  </div>
</template>
<script>
export default {
    computed:{
		backgroundImage(){
			return this.user.photo;
		}
	},
    data(){
		return{
			user:{},
            heads:[
                'issue_date',
                'authors',
                'barcode',
                'inv_id',
                'title',
                'status'
            ],
            data:[]
		}
	},
    methods:{
        getInfo(){
			this.$http.get('/user/my-books').then(response=>{
				this.user=response.data.res;
				this.user.info=objectWithoutKey(this.user.info,['id','user_cid']);
                this.data=this.user.history;
			}).catch(e=>{
				this.goTo('users');
			})
		},
        objectWithoutKey(object,key){
            return objectWithoutKey(object,key);
        },
        capitalize(string){
            return capitalize(string);
        }

    },
    created(){
        this.getInfo();
    }
}
</script>
<style scoped>
.image{
	background-repeat: no-repeat;
	background-size: 100% 100%;
}
.imageWidth{
	width:13em;
}
.imageHeight{
	height: calc(13em * 4/3);
}
table {
	border-collapse: collapse;
	width: 100%;
}

td, th {
	border: 0.0625em solid #E8E8E8;
	padding: 1em 1.25em;
}

th{
	text-align: left;
	font-weight: 500;
}

tbody tr:hover{
	box-shadow: 0 0 0.4375em rgba(8, 38, 115, 0.2);
}

.table{
	position: relative;
	max-height: max(68vh,31.25em);
	overflow: auto;
	border-bottom:0.0625em solid #E8E8E8;
	border-top:0.0625em solid #E8E8E8;
}

.header{
	position: sticky;
	top: 0;
	border-top: none;
	z-index: 1;
}
</style>

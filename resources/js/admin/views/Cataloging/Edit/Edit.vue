<template>
    <div class="d-flex">
		<div class="bg-white mt-2 w-100 py-3 px-4">
            <div class="mb-3">
                <back />
            </div>
            <div class="d-flex justify-content-between">
                <div>Management au mau</div>
                <div class="d-flex">
                    <button class="outline-black mx-3">
                        Print au mau
                    </button>
                    <button class="outline-black">
                        Previews    
                    </button>
                    <button class="outline-black mx-3">
                        Import from Worldcats
                    </button>
                    <button class="bg-green color-white">
                        XML
                    </button>
                </div>
            </div>
            <div class="d-flex mt-5">
                <div class="text-center p-1 py-3 border rounded">
                    <div class="text-grey font-size-14 py-2 my-1">
                        Section
                    </div>
                    <div class="py-2 my-1 cursor-pointer px-3 border rounded border-orange text-orange">
                        Section
                    </div>
                    <div class="py-2 my-1 cursor-pointer ">
                        Section
                    </div>
                    <div class="py-2 my-1 cursor-pointer ">
                        Section
                    </div>
                    <div class="py-2 my-1 cursor-pointer ">
                        Section
                    </div>
                    <div class="py-2 my-1 cursor-pointer ">
                        Section
                    </div>  
                </div>
                <div class="p-3 ml-3 border rounded flex-fill ">
                    <div class="text-grey font-size-14 py-2 my-1">
                        Section tag
                    </div>
                    <div class="d-flex">
                        <div class="rounded px-3 py-2 bg-orange text-white font-weight-bold">
                            020
                        </div>
                        <div class="rounded px-3 py-2 bg-lightgrey ml-2 text-grey font-weight-bold">
                            050
                        </div>
                        <div class="rounded px-3 py-2 bg-lightgrey ml-2 text-grey font-weight-bold">
                            080
                        </div>
                    </div>
                    <div class="text-center font-weight-bold">
                        INTERNATIONAL STANDARTE
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="3" class="tline">
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    haha
                                </th>
                                <th>
                                    muahaha
                                </th>
                                <th>
                                    mew
                                </th>
                            </tr>
                            <tr>
                                <th colspan="3" class="tline">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Bro
                                </td>
                                <td>
                                    Che tam
                                </td>
                                <td>
                                    Che tam bro
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex">
                        <button class="ml-auto width-unset">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Back from '../../../components/common/Back.vue'
export default {
  components: { Back },
  methods:{
      getEditInfo(){
          this.$http.get('cataloging/material/edit-data').then(response=>{
              console.log(response);
          })
      }
  },
  created(){
      this.getEditInfo();
  }
}
</script>
<style scoped>
table {
	border-collapse: separate;
    border-spacing:2em .875em;
}

td{
	border: 0.0625em solid #9C9FA7 !important;
    border-radius: .3125em;
    
	padding: 1em 1.25em;
}

th {
	text-align: left;
	font-weight: 500;
    border: none !important;
    padding-top: 0;
    padding-bottom: 0;
}
.tline{
    border-top:0.0625em solid #E8E8E8 !important;
    padding:0;
}
</style>
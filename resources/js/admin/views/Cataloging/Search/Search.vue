<template>
    <div class="d-flex">
		<div class="bg-white mt-2 w-100 py-3 px-4">
            <form class="d-flex">
                <div class="select position-relative">
                    <select class="no_border_right h-100">
                        <option>{{$tc('a?')}}</option>
                    </select>
                    <label class="placeholder">{{$t('type')}}</label>
                </div>
                <div class="flex-fill col-6 mx-3">
                    <input-div :search='true' :placeholder="$t('search_cataloging')"/>
                </div>
                <div class="ml-auto">
                    <button type="submit" class="px-5">{{$t('search')}}</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import InputDiv from "../../../components/common/Input.vue";

export default{
  components: { InputDiv },
  data(){
      return{
      }
  }
}
</script>
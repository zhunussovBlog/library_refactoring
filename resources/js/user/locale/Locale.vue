<template>
    <router-view></router-view>
</template>
<script>
import setLocale from '../mixins/langs'
export default {
    mixins:[setLocale],
    created(){
        let lang=this.$route.matched[0].meta.lang;
        if(!lang){
            this.$router.push('en');
        }
        this.setLang(lang);
    }
}
</script>
<template>
    <main-body/>
</template>
<script>
import MainBody from './views/__main__'
import setLocale from './mixins/setLocale'
export default {
    components:{
        MainBody
    },
    mixins:[setLocale],
    methods:{
        getAuth(){
            // checks if the user is logined
            this.$http.get('/user').then(response => {
                this.$store.commit('setUser',response.data.res.user);
            }).catch(e=>{});
        },
        setGlobalLocale(){
            this.setLocale(JSON.parse(localStorage.getItem('lang')));
        }
    },
    created () {
        this.getAuth();
        this.setGlobalLocale();
    }
}
</script>
<style scoped>
@import './assets/styles/style.css'
</style>
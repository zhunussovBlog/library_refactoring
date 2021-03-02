<template>
    <main-body/>
</template>
<script type="text/javascript">
    import MainBody from './views/__main__'

    import langs from './mixins/langs'
    export default{
        mixins:[langs],
        components:{
            MainBody
        },
        methods:{
            setLanguage(){
                this.$i18n.locale=JSON.parse(localStorage.getItem('lang')) || 'en';
            },
            checkLogin(){
                this.$http.get('user').then(response=>{
                    this.$store.commit('setUser',response.data.res.user);
                })
            }
        },
        created(){
            this.setLanguage();
            this.checkLogin();
        }
    }
</script>
<style>
@import './assets/styles/style.css'
</style>
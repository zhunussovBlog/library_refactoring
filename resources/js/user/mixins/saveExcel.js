export default{
	computed:{
		selected(){
			return this.$store.getters.selected;
		}
	},
	methods:{
		saveExcel(){
			this.$store.commit('setLoading',true);
			let media={media:this.$store.getters.selected.data};
			if(this.$store.getters.selected.all){
				media.all=true;
			}
			this.$http.post('media/save-excel', media,{
				responseType: 'blob',
			}).then((res) => {
				this.$store.commit('setLoading',false);
				const url = window.URL.createObjectURL(new Blob([res.data]));
				const link = document.createElement('a');
				link.href = url;
				link.setAttribute('download', 'media.xlsx');
				document.querySelector('#app').appendChild(link);
				link.click();
			}).catch((err) => {
				this.$store.commit('setLoading',false);
				if(media.media.length==0){
					this.$fire({
						title:this.$t("download"),
						text:"Nothing selected. Please, select the media you want to save as data in excel file",
						type:"error",
					});;
				}
				else{
					this.$fire({
						title:this.$t("download"),
						text:err.message ?? this.$t('error'),
						type:"error",
					});;
				}
			});

		},
		selectAll(){
			this.$store.state.selected.data=[];
			this.$store.state.selected.all=!this.$store.state.selected.all;
		}
	}
}
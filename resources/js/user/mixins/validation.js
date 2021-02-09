export const encode={
	methods:{
		encode(string){
			if(string !=''){
				return encodeURIComponent(string);
			}
			else{
				return string;
			}
		}
	}
}
export const validate={
	methods:{
		validate(string,nullAllowed){
			if(string.replace(/\s/g, "").length>=2 || (string.length==0&&nullAllowed)){
				return true;
			}
			else{
				return false;
			}
		}
	}
}
export const warn={
	methods:{
		warn(id,show){
			var warning=document.getElementById('warn-'+id);
			if(show){
				warning.style.opacity='1';
			}
			else{
				warning.style.opacity='0';
			}
		}
	}
}
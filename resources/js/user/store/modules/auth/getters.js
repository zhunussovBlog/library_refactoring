export default{
	user:state=>state.user,
	logged:state=>state.user ? Object.keys(state.user).length>0 : false
}

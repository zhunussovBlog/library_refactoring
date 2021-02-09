export default{
	success:(response)=>response.data.res.message ?? "Successful!",
	error:(error)=>error.response.data.message ?? 'Uncaught problem'
};
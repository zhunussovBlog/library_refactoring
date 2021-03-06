let links =[
{
	name:'about',
	link:'https://sdu-kz.libguides.com/about_us'
},
{
	name:'services',
	link:'https://sdu-kz.libguides.com/libservices'
},
{
	name:'ask_a_librarian',
	link:'https://sdu-kz.libguides.com/ask-a-librarian_page'
},
{
	name:'quick_links.title',
	target:'',
	link:'javascript:;',
	dropdown:{
		links:[
		{
			name:'quick_links.az',
			link:'https://sdu-kz.libguides.com/az.php'
		},
		{
			name:'quick_links.bookpurchase',
			link:'https://sdu-kz.libguides.com/libservices/bookpurchase'

		},
		{
			name:'lib_guides',
			link:'https://sdu-kz.libguides.com/'
		},
		{
			name:'quick_links.askus',
			link:'https://sdu-kz.libguides.com/ask-a-librarian_page/askus'
		},
		{
			name:'quick_links.ill',
			link:'https://sdu-kz.libguides.com/libservices/ill'
		},
		{
			name:'quick_links.booking',
			link:'https://sdu-kz.libguides.com/libservices/booking'
		},
		{
			name:'quick_links.appointments',
			link:'https://sdu-kz.libcal.com/appointments'
		},
		{
			name:'quick_links.subject',
			link:'https://sdu-kz.libguides.com/sl_profiles/page'
		},
		{
			name:'quick_links.digest',
			link:'https://sdu-kz.libguides.com/LibReview'
		},
		{
			name:'quick_links.moodle',
			link:'https://sdu-kz.libguides.com/libservices/moodle'
		}
		]
	}
},
{
	name:'research_consultations',
	link:'https://sdu-kz.libguides.com/research_consultations'
},
{
	name:'instructor_support',
	link:'https://sdu-kz.libguides.com/instructor_support'
}
];
export default{
	computed:{
		lib_links(){
			return links.filter(link=>link.link!=undefined);
		}
	}
}
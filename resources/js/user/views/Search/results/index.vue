<template>
	<div>
		<div class="padding font-weight-bold font-size-24">
			{{$t('results_for')}}
		</div>
		<div class="padding bg-lightgrey d-flex mt-3 py-3">
			<div class="filter-width"></div>
			<div class="d-flex justify-content-between flex-fill">
				<div class="d-flex align-items-center">
					<checkbox />
					<span class="ml-2">{{$t('select_all')}}</span>
				</div>
				<div>
					<button>{{$t('export_all')}}</button>
				</div>
			</div>
		</div>
		<div class="padding d-flex align-items-start mt-3">
			<filter-div	class="flex-shrink-0" />
			<div class="flex-grow-1">
				<book-card/>
				<book-card/>
				<book-card/>
				<book-card/>
				<book-card/>
				<pagination />
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	import FilterDiv from './components/filter'
	import BookCard from './components/book_card'
	import Pagination from './components/pagination'
	import Checkbox from '../../../components/checkbox'
	export default{
		components:{
			FilterDiv,
			BookCard,
			Pagination,
			Checkbox
		}
	}
</script>
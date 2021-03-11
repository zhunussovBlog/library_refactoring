<template>
	<div class="d-flex align-items-center">
		<div class="w-100 d-flex">
			<div class="pad w-100">
				<input type="date" 	/>
				<label class="placeholder">From date</label>
			</div>
			<div class="pad w-100">
				<input type="date" 	/>
				<label class="placeholder">To date</label>
			</div>
		</div>
		<div class="align-items-center w-100">
			<div class="relative pad ml-4">
				<Dropdown title="Choose department" :items="['Enginering','Not enginering']" dropdownClasses="dropdown-left" :dropup="true"/>
			</div>
			<div class="relative pad ml-4">
				<Dropdown title="Choose type" :items="['Student','Staff']" dropdownClasses="dropdown-left" :dropup="true"/>
			</div>
			<div class="pad ml-auto">
				<button>Search</button>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
//components
import Dropdown from '../../../components/common/Dropdown'
export default{
	components:{
		Dropdown
	}
}
</script>
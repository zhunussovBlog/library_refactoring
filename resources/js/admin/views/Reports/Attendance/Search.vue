<template>
	<div class="row align-items-center">
		<div class="full-width row">
			<div class="pad full-width">
				<input type="date" 	/>
				<label class="placeholder">From date</label>
			</div>
			<div class="pad full-width">
				<input type="date" 	/>
				<label class="placeholder">To date</label>
			</div>
		</div>
		<div class="align-items-center full-width">
			<div class="relative pad ml-20">
				<Dropdown title="Choose department" :items="['Enginering','Not enginering']" dropdownClasses="dropdown-left" :dropup="true"/>
			</div>
			<div class="relative pad ml-20">
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
<template>
<div>
	
</div>

</template>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				testshow: true,
			}
		},
		props: {
			show: Boolean,
		},
		watch:{
			show(val) {
				console.log(val);
				
			}
		}
	}
</script>
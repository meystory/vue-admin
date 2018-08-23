<template>
	<div class="page-title" style="padding:0px 0px; ">
		<!-- 面包屑 -->
		<div class="breadcrumb-env">
			<ol class="breadcrumb bc-1" style="margin:3px 0px;">
				<li v-if="$route.path !='/' " v-for="matched in $route.matched" :class="{ 'active': matched==$route.path }">

					<a href="javascript:void(0);" style="color: #0a0a0a;" v-if="matched.parent" @click.prevent="redirectTo(matched.path)">{{ matched.name }}</a>
					<a v-else >{{ matched.name }}</a>
				</li>
			</ol>	
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		methods: {
			redirectTo(path) {
				this.$router.push({ path : path});
			}
		}
	}
</script>
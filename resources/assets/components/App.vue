<template>
	<div id="app"  class="page-body" style="height:100%">
		<div class="page-container"> 
        	<sidebar></sidebar>
	        <div class="main-content">
	        	<navlist></navlist>
	        	<Pagetitle></Pagetitle>
	            <router-view></router-view>

	            
	            <!-- footer -->
	            <footer class="main-footer sticky footer-type-1" style="">
					<div class="footer-inner">
					
						<!-- Add your copyright text here -->
						<div class="footer-text">
							© 2018
							<strong>custom</strong> 
							theme 
						</div>
						
						<!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
						<div class="go-up">
						
							<a href="#" rel="go-top">
								<i class="fa-angle-up"></i>
							</a>
							
						</div>
						
					</div>
			    </footer>
	        </div>
	    </div>
	    <vue-progress-bar></vue-progress-bar>
	</div>
</template>
<script >

	import Sidebar from './layouts/Sidebar.vue';
	import Navlist from './layouts/Navlist.vue';
	import Pagetitle from './layouts/Pagetitle.vue';

	import { mapState, mapActions, mapGetters} from 'vuex';
	export default {
		components: {
            Sidebar,
            Navlist,
            Pagetitle,
        },
        mounted() {

        	
        }
	}
</script>

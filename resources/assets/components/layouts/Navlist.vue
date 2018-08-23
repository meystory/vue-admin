<template>
	<nav class="navbar user-info-navbar" role="navigation">
    	<ul class="user-info-menu left-links list-inline list-unstyled">
			
			<li class="hidden-sm hidden-xs">
				<a href="#" data-toggle="sidebar">
					<i class="fa-bars"></i>
				</a>
			</li>

			<!-- 聊天私信 -->
			<li class="dropdown hover-line" style="min-height: 78px;">
				<a href="#" data-toggle="dropdown">
					<i class="fa-envelope-o"></i>
					<span class="badge badge-green">15</span>
				</a>
					
				<ul class="dropdown-menu messages">
					<li>
							
						<ul class="dropdown-menu-list list-unstyled ps-scrollbar ps-container">
						
							<li class="active"><!-- "active" class means message is unread -->
								<a href="#">
									<span class="line">
										<strong>欧囧</strong>
										<span class="light small">- yesterday</span>
									</span>
									
									<span class="line desc small">
										昨天踩到东西了，你猜是啥.
									</span>
								</a>
							</li>
							
							<li class="active">
								<a href="#">
									<span class="line">
										<strong>Salma Nyberg</strong>
										<span class="light small">- 2 days ago</span>
									</span>
									
									<span class="line desc small">
										Oh he decisively impression attachment friendship so if everything. 
									</span>
								</a>
							</li>
							
							<div class="ps-scrollbar-x-rail" style="display: block; width: 0px; left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="display: block; top: 0px; height: 0px; right: 2px;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div>
						</ul>
						
					</li>
					
					<li class="external">
						<a href="blank-sidebar.html">
							<span>All Messages</span>
							<i class="fa-link-ext"></i>
						</a>
					</li>
				</ul>
			</li>

			<!-- 通知 -->
			<li class="dropdown hover-line" style="min-height: 78px;">
				<a href="#" data-toggle="dropdown">
					<i class="fa-bell-o"></i>
					<span class="badge badge-purple">7</span>
				</a>
					
				<ul class="dropdown-menu notifications">
					<li class="top">
						<p class="small">
							<a href="#" class="pull-right">Mark all Read</a>
							You have <strong>3</strong> new notifications.
						</p>
					</li>
					
					<li>
						<ul class="dropdown-menu-list list-unstyled ps-scrollbar ps-container ps-active-y">
							<li class="active notification-success">
								<a href="#">
									<i class="fa-user"></i>
									
									<span class="line">
										<strong>意向审核通过</strong>
									</span>
									
									<span class="line small time">
										30 seconds ago
									</span>
								</a>
							</li>
							
						
							<li class="notification-primary">
								<a href="#">
									<i class="fa-thumbs-up"></i>
									
									<span class="line">
										<strong>正常通知</strong>
									</span>
									
									<span class="line small time">
										2 minutes ago
									</span>
								</a>
							</li>
							
							<li class="notification-danger">
								<a href="#">
									<i class="fa-calendar"></i>
									
									<span class="line">
										危险通知
									</span>
									
									<span class="line small time">
										9 hours ago
									</span>
								</a>
							</li>
							
							<div class="ps-scrollbar-x-rail" style="display: block; width: 0px; left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="display: block; top: 0px; height: 0px; right: 2px;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div>
						</ul>
					</li>
					
					<li class="external">
						<a href="#">
							<span>View all notifications</span>
							<i class="fa-link-ext"></i>
						</a>
					</li>
				</ul>
			</li>
		</ul>
		
		<ul class="user-info-menu right-links list-inline list-unstyled">
			<!-- 用户信息 -->
			<li class="dropdown user-profile" style="min-height: 78px;">
				<a href="#" data-toggle="dropdown">
					<img :src="auth.avatar" alt="user-image" class="img-circle img-inline userpic-32" width="28">
					<span>
						{{ auth.username }}
						<i class="fa-angle-down"></i>
					</span>
				</a>
				
				<ul class="dropdown-menu user-profile-menu list-unstyled">
					<li>
						<a href="#edit-profile">
							<i class="fa-edit"></i>
							编辑
						</a>
					</li>

					<li class="last">
					<!-- extra-lockscreen.html -->
						<a  href="#logout" @click.prevent="logout()">
							<i class="fa-lock"></i>
							退出登录
						</a>
					</li>
				</ul>
			</li>

			<li style="min-height: 78px; width:30px">
			</li>
		</ul>
	</nav>
</template>
<script>
	export default {
		data() {
			return {
				auth : this.$store.state.auth
			}
		},
		mounted() {

        },
        methods: {
        	logout() {
        		this.$axios({
        			url: '/logout',
        			data: {},
 					success: function() {
 						location.href = '/login';
 					}
        		});
        	}
        },
        created() {

        }
	}
</script>
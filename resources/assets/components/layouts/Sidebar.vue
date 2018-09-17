<template>
<div class="sidebar-menu toggle-others fixed" >
            
            <div class="sidebar-menu-inner ps-container ps-active-y">   
                
                <header class="logo-env">
                    
                    <!-- logo -->
                    <div class="logo">
                        <a href="#" class="logo-expanded">
                            <img src="/images/logo@2x.png" width="80" alt="">
                        </a>
                        
                        <a href="#" class="logo-collapsed">
                            <img src="/images/logo-collapsed@2x.png" width="40" alt="">
                        </a>
                    </div>
                    
                    <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
                    <div class="mobile-menu-toggle visible-xs">
                        <a href="#" data-toggle="user-info-menu">
                            <i class="fa-bell-o"></i>
                            <span class="badge badge-success">7</span>
                        </a>
                        
                        <a href="#" data-toggle="mobile-menu">
                            <i class="fa-bars"></i>
                        </a>
                    </div>                                
                </header>
                        
                <ul id="main-menu" class="main-menu">
                   <!--  add class "multiple-expanded" to allow multiple submenus to open
                    class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
                    <li v-for="menu in menuTree" :class="{'opened expanded active': menu.action == modular.parent}">
                        <a href="#">
                            <i :class="menu.linecons"></i>
                            <span class="title">{{ menu.title }}</span>
                        </a>
                        <ul >
                            <li v-for="child in menu.child" :class="{ 'active': child.action == modular.child }">
                                <router-link :to="child.action">
                                    <span class="title">{{ child.title }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            <!-- 滚轮 -->
            <div class="ps-scrollbar-x-rail" style="display: block; width: 340px; left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="display: inherit; top: 0px; height: 363px; right: 2px;"><div class="ps-scrollbar-y" style="top: 0px; height: 159px;"></div></div></div>
            
        </div>
</template>

<script>
    import { mapState, mapActions, mapGetters} from 'vuex';
    export default {
        computed: {
            ...mapState(['menuTree', 'modular']),
        },
        created() {

        }
    }
</script>


import Parent from './components/layouts/Parent.vue'
export default [
	{
		path : '/',
		name: '首页',
		component : require('./components/index/Index.vue')		
	},
	{
		path : '/test',
		name: '测试页',
		component : require('./components/ImgCropper.vue')		
	},
	{	
		path: '/node',
        component: Parent,
        name: '节点管理',
        children: [
            {
                path: 'list',
                name: '节点列表',
                meta: {'parent':'/system'},
                component: require('./components/system/node/Node.vue')
            },
            {
                path: 'edit/:node_id?',
                name: '修改/新增节点',
                meta: {'parent':'/system'},
                component: require('./components/system/node/Node.vue')
            }

        ]

	},
	{	
		path: '/role',
        component: Parent,
        name: '角色管理',
        
        children: [
            {
                path: 'list',
                name: '角色列表',
                meta: {'parent':'/system'},
                component: require('./components/system/role/Role.vue')
            },
            {
                path: 'edit/:role_id?',
                name: '修改/新增角色',
                meta: {'parent':'/system'},
                component: require('./components/system/role/EditRole.vue')
            }

        ]

	},
	{
		path: '/user',
		component: Parent,
		name: '员工管理',

		children: [
			{
				path: 'list',
				name: '员工列表',
				meta: {'parent':'/structure'},
				component: require('./components/structure/user/List.vue')
			},
			{
				path: 'edit/:user_id?',
				name: '修改/新增员工',
				meta: {'parent':'/structure'},
				component: require('./components/structure/user/Edit.vue')
			}
		]
	},
	{
		path: '/depa',
		component: Parent,
		name: '部门管理',

		children: [
			{
				path: 'list',
				name: '部门列表',
				meta: {'parent':'/structure'},
				component: require('./components/structure/depa/List.vue')
			},
			{
				path: 'edit/:user_id?',
				name: '修改/新增部门',
				meta: {'parent':'/structure'},
				component: require('./components/structure/depa/Edit.vue')
			}
		]
	},

	{
		path: '/notify',
		component: Parent,
		name: '消息管理',

		children: [
			{
				path: 'list',
				name: '消息列表',
				meta: {'parent':'/notify'},
				component: require('./components/notify/List.vue')
			},
		]
	},

	//公共路由
	{
		path: 'error',
		name: '404页面',
		component: require('./components/layouts/Error.vue'),
	},
 //    {
 //        path: '*',
 //        redirect: '/'
 //    }

];
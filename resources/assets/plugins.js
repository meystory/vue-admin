

/*####  表单验证插件####*/
import VeeValidate, { Validator } from 'vee-validate';
import zh_CN from 'vee-validate/dist/locale/zh_CN';

//修改本地语言包
Validator.localize('zh_CN',zh_CN);

//自定义规则
Validator.extend('zh_char', {
    getMessage: (field,args) =>{
        let [min,max] = args;
        return `必须是${min}-${max}位中文字符.`;
    },
    validate: (value,args) => {
        let [min,max] = args;
        let pattern = "^[\u4E00-\u9FA5\uf900-\ufa2d/]{"+min+","+max+"}$";
        pattern = new RegExp(pattern);
        return pattern.test(value);
    } 

});
Validator.extend('mobile',{
    getMessage: (field)=> '手机号格式不正确.',
    validate: (value)=>{
        return /^1[3578]\d{9}$/.test(value);
    }
});

Validator.extend('select_id',{
    getMessage: (field,args)=> {
        return '请选择'+field;
    },
    validate: (value)=>{
        return parseInt(value) > 0 ;
    }
});

Validator.extend('node_action',{
    getMessage: (field)=> '请输入英文、斜杠或下划线.',
    validate: (value)=>{
        return /^[a-zA-Z_/]+$/.test(value);
    }
});
//全局定义消息配置
const dictionary = {
   zh_CN: {
    messages: {
    	required: (field,args)=>{
            return '请填写'+field;
        }, 
    	alpha_dash: ()=> '必须是数字、字母、或下划线',
        email: ()=> '邮箱格式不正确',
    },
	attributes:{
	   	email:'邮箱',
	   	mobile: '手机号',
	}
  }
};

Validator.localize(dictionary);

Vue.use(VeeValidate, { locale : 'zh_CN'});


/*####  confirm弹框插件 ####*/
window.swal = require('sweetalert2');
swal = swal.mixin({
    showCancelButton: true,
    confirmButtonText: '确定',
    cancelButtonText: "取消",
    confirmButtonColor: '#8cd4f5',
    cancelButtonColor: '#c1c1c1',
    type: "warning",
    title: "确定要删除?",

    // 使用自定义样式
    // buttonsStyling: false,
    // confirmButtonClass: 'btn btn-info',
    // cancelButtonClass: 'btn btn-gray',
  	
});


/*####  进度条插件 ####*/
import VueProgressBar from 'vue-progressbar';

const progressOption = {
    color: '#00a65a',
    failedColor: 'red',
    thickness: '5px',
    height: '2px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    }
}

Vue.use(VueProgressBar, progressOption);
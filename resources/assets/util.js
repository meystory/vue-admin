/**
 * 重写axios
 * 
 */
exports.install = function (Vue, options) {

    //公共请求方法
    Vue.prototype.$axios = function ({type, url, data, success, fail}) {

        type = typeof type == 'undefined' ? 'post' : type.toLowerCase();

        //get请求默认加上params
        if(type == 'get'){
            data = { params: data};
        }
        
        this.$Progress.start();
        axios[type](url, data).then(response=>{
            
            if(response.data == '')
            {
                toastr.warning('响应获取失败');
            }

            if(response.data.status == 1)
            {   
                if(typeof success == 'function')
                {   
                    success.apply(this, [response.data.data]);
                }
                if(response.data.msg){
                    toastr.success(response.data.msg);
                }
                
            }else
            {   if(typeof fail == 'function')
                {
                    fail.apply(this);
                }
                toastr.error(response.data.msg);
            }
            this.$Progress.finish();

        }).catch(error=>{
            console.log(error);
            error = error.response;
            if (error.data.error == 'Unauthenticated.') {
                toastr.error('登录超时');
                setTimeout(function(){
                    console.log('跳转');
                    location.href = '/login';
                },10);
                
            } else {
                //表单验证类错误
                if((typeof error.data == 'object') && error.status == 422)
                {   
                    for(let field in error.data)
                    {   
                        let [err_str] = error.data[field];
                        this.errors.add({field:field, msg:err_str});
                    }
                }else
                {
                    toastr.error('', '出错啦!');
                }
            }
        });
    }
    Vue.prototype.can = function (action) {

        let permissions = this.$store.state.permissions;

        if(action==permissions.indexOf(action) === -1){
            return false;
        }
        return true;
    }
};
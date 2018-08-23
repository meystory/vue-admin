@extends('layouts.login')

@section('content')
    <div class="login-container">
    
        <div class="row">
        
            <div class="col-sm-6">
                            
                <!-- Add class "fade-in-effect" for login form effect -->
                <form method="post" role="form" id="login" class="login-form fade-in-effect">

                    <div class="login-header">
                        <a href="#" class="logo">
                            <img src="{{ asset('images/logo@2x.png') }}" alt="" width="80" />
                        </a>
                        
                        <p></p>
                    </div>
    
                    
                    <div class="form-group">
                        <label class="control-label" for="username">用户名</label>
                        <input type="text" class="form-control input-dark" name="username" id="username" autocomplete="off" />
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="password">密&emsp;码</label>
                        <input type="password" class="form-control input-dark" name="password" id="password" autocomplete="off" />
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark  btn-block text-left">
                            <i class="fa-lock"></i>
                            登录
                        </button>
                    </div>
                    
                    <!-- <div class="login-footer">
                        <a href="#">忘记密码？</a>                        
                    </div> -->
                </form>
                
                <!-- External login -->
               <!--  <div class="external-login ">
                    <a href="#" class="wechat">
                        <i class="fa-wechat"></i>
                        微信登录
                    </a>
                </div> -->
                
            </div>
            
        </div>
        
    </div>

@endsection


@section('js')

<script type="text/javascript"  src="{{ asset('js/jquery/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
	$('body').addClass('login-page');
    $(function(){
    	setTimeout(function(){ $(".fade-in-effect").addClass('in'); }, 1);
		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });		
						
		// Validation and Ajax action
		$("form#login").validate({
			rules: {
				username: {
					required: true
				},
				
				password: {
					required: true
				}
			},
			
			messages: {
				username: {
					required: '请输入账号'
				},
				
				password: {
					required: '请输入密码'
				}
			},
			
			// Form Processing via AJAX
			submitHandler: function(form)
			{

				show_loading_bar(70); // Fill progress bar to 70% (just a given value)

				var $username = $(form).find('#username');
				var $password = $(form).find('#password');;

				$.ajax({
					url: "/login",
					method: 'POST',
					dataType: 'json',
					data: {
						username: $.trim($username.val()),
						password: $.trim($password.val()),
					},
					success: function(response)
					{
						show_loading_bar({
							delay: .5,
							pct: 100,
							finish: function(){
								
								if(response.status == 1)
								{
									window.location.href = '/';
								}else 
								{	
									
									toastr.error(response.msg);
									$password.select();
								}
							}
						});
						
					},
					error:function(error)
					{		
						toastr.error(error.responseJSON[Object.keys(error.responseJSON)[0]]);
					}
				});
			}
		});
		// Set Form focus
		$("form#login .form-group:has(.form-control):first .form-control").focus();
    })
</script>
@endsection

<template>

	<div class="col-sm-12">		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{{ formData.user_id ? '修改用户' : '新建用户'}}</h3>
			</div>
			<div class="panel-body">
				
				<form role="form" ref="user-form" class="form-horizontal">
					<div class="form-group" :class=" errors.has('username') ? 'has-error': '' ">
						<label class="col-sm-1 control-label">账&emsp;号</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" v-model.trim="formData.username" name="username"  v-validate="{ required:true, alpha_dash: true, max:20, min:6 }" data-vv-as="账号" autocomplete="off">
						</div>
						<span class="help-block">&nbsp;{{ errors.first('username') }}</span>
					</div>
					
					
					<div class="form-group" :class=" errors.has('name') ? 'has-error': '' ">
						<label class="col-sm-1 control-label">姓名</label>
						
						<div class="col-sm-7">
							<input type="text" class="form-control" name="name" v-validate="{ required:true, zh_char:[2,10]}" v-model.trim="formData.name" placeholder="" data-vv-as="姓名" autocomplete="off">
						</div>
						<span class="help-block">&nbsp;{{ errors.first('name') }}</span>
					</div>
					
					<div class="form-group">
						<label class="col-sm-1 control-label">头像</label>
						
						<div class="col-sm-7">
							<div style="width: 128px;height: 128px;">
								<img style="width:100%;height: 100%;" v-show="formData.avatar" :src="formData.avatar" >
							</div>
							<div style="margin-top: 10px;">
								<ImgCropper v-on:cropperImg="getFileInfo"></ImgCropper>
							</div>
						</div>
					</div>

					<div class="form-group" :class=" errors.has('mobile') ? 'has-error': '' ">
						<label class="col-sm-1 control-label">手机号</label>
						
						<div class="col-sm-7">
							<input type="text" class="form-control" name="mobile" v-validate="{ required:true, mobile:true }" v-model.trim="formData.mobile" placeholder="" autocomplete="off">
						</div>
						<span class="help-block">&nbsp;{{ errors.first('mobile') }}</span>
					</div>

					<div class="form-group" :class=" errors.has('email') ? 'has-error': '' ">
						<label class="col-sm-1 control-label">邮&emsp;箱</label>
						
						<div class="col-sm-7">
							<input type="text" class="form-control" name="email" v-validate="{ required:true, email:true }" v-model.trim="formData.email" placeholder="" autocomplete="off">
						</div>
						<span class="help-block">&nbsp;{{ errors.first('email') }}</span>
					</div>			

					<div class="form-group" :class=" errors.has('depa_id') ? 'has-error': '' ">
						<label class="col-sm-1 control-label">部&emsp;门</label>
						<div class="col-sm-7">
							<select class="form-control" v-model="formData.depa_id" v-validate="{ select_id:true }" name="depa_id" data-vv-as="部门">
								<option value="0">请选择</option>
								<option value="1">总公司</option>
								<option value="2">销售部</option>
								<option value="3">研发部</option>
								<option value="4">宣传部</option>

							</select>
						</div>
						<span class="help-block">&nbsp;{{ errors.first('depa_id') }}</span>
					</div>
					
					<div class="form-group">
						<label class="col-sm-1 control-label">性&emsp;别</label>
						<div class="col-sm-7">
							<p>
								<label class="cbr-inline">
									<div class="cbr-replaced cbr-primary cbr-radio" :class="{ 'cbr-checked' : formData.sex==1 }" >
										<div class="cbr-input">
											<input type="radio" name="sex" value="1" v-model="formData.sex" class="cbr cbr-done">
										</div>
										<div class="cbr-state">
											<span></span>
										</div>
									</div>
									男
								</label>
								<label class="cbr-inline">
									<div class="cbr-replaced cbr-primary cbr-radio" :class="{ 'cbr-checked' : formData.sex==2 }">
										<div class="cbr-input">
											<input type="radio" name="sex" value="2" v-model="formData.sex" class="cbr cbr-done">
										</div>
										<div class="cbr-state">
											<span></span>
										</div>
									</div>
									女
								</label>
							</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"></label>
						<div class="col-sm-7">
							<button type="button" class="btn btn-gray  pull-right" @click="formSubmit()">提&emsp;交</button>
						</div>
						
					</div>
				</form>
				
			</div>
		</div>
		
	</div>
</template>
<script type="text/javascript">
	import ImgCropper from './../ImgCropper.vue';
	export default {
		components:{
			ImgCropper
		},
		data() {
			return {
				formData:{
					username: '',
					name: '',
					mobile: '',
					depa_id: 0,
					email: '',
					sex: 1,
					avatar: '/images/user-2.png',
				},
				user_id: null,
				fileInfo: '', 
				
			}
		},
		created() {
			this.user_id = this.$route.params.user_id; 

			//根据id 读取表单数据
			if(this.user_id){	

				this.$axios({
					type: 'get',
					url : '/user/info',
					data: {user_id: this.user_id},
					success:function(data){
						for(let i in this.formData){
							this.formData[i] = data[i];
						}	
					}

				});
			}
			
		},
		methods: {
			formSubmit() {

				this.$validator.validate().then(result=>{
					if(result)
					{
						//提交数据
						let data = new FormData(this.$refs['user-form']);
						data.append('user_id', this.user_id);
						data.append('avatar', this.fileInfo);

						this.$axios({
							url : '/user/add',
							data: data,
							success:function(data){

								this.$router.push({ path: '/user/list' });
							},
							
						});
					}
				});
			},
			getFileInfo(data) {
				this.fileInfo = data.file;
				this.formData.avatar = data.src;
			}
		}
	}
</script>
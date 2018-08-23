<template>
<!-- 单个图片及裁剪上传 -->
<div>
	<input @change="fileChange($event)" ref="imgInput" id="imgInput" type="file"  multiple style="display: none"/>
	<button type="button" class="btn btn-success btn-xm" onclick="document.getElementById('imgInput').click();">
		<i class="fa-folder-open"></i>&emsp;选择图片
	</button>

	<div class="modal fade" :class="showModal ? 'in show' : '' " role="dialog" tabindex="-1" data-backdrop="static" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				
				<div class="modal-header">
					<h4 class="modal-title">头像裁剪</h4>
				</div>
				
				<div class="modal-body">
					<img ref="img-cropper"  v-if="imgFile" style="max-width:100%;max-height: 100%;" :src="imgFile.src">
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal" @click="cropperData()">确定</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-backdrop fade in" v-if="showModal"></div>
</div>
	    
</template>

<script type="text/javascript">
	import 'cropperjs/dist/cropper.min.css';
	require('cropperjs/dist/cropper.min.js');
	require('jquery-cropper/dist/jquery-cropper.min.js');

	export default {
		data(){
			return {
				imgFile: null,
				size: 0,
				showModal: false,
			}
		},
		methods: {
			fileChange(e) {
				if(e.target.files.length > 1){
					toastr.error('只能选择一个文件!');
					return;
				}
				if(!e.target.files[0].size ) return;

				let file = e.target.files[0];
				if(file.type.indexOf('image') == -1)
				{
					toastr.error('请选择正确图片的格式:jpg、png!');
					return;
				}

				let that = this;
				let reader = new FileReader();
				reader.readAsDataURL(file);
				
				reader.onload = function(){
					file.src = this.result;
					//赋值
					that.imgFile = file;
					that.showModal = true;
					setTimeout(function(){
						that.cropperAuto();
					},1);


					// let image = new Image();
					// image.onload = function(){

					// 	file.width = image.width;
					// 	file.height = image.height;
					// 	that.file = file;
					// 	image.src= file.src;	
					// }
					
				}
				
			},
			cropperAuto() {

		    	let imgBox= this.$refs['img-cropper'];
		    	$(imgBox).cropper({
		    		aspectRatio: 3 / 3,
		    		viewMode: 1,
		    		movable: false,
		    		zoomOnWheel: false,
		    		autoCropArea: 0.6,
		    	});
		    	
		    },
		    cropperData() {

		    	let imgBox= this.$refs['img-cropper'];

		    	let canvas = $(imgBox).cropper('getCroppedCanvas');
		    	//通过canvas获取数据流
		    	let that = this;
		    	let orgImg = that.imgFile;
		    	canvas.toBlob(function(blob){
      				let url = URL.createObjectURL(blob)

		    		var file = new File([blob],orgImg.name,{type:orgImg.type});

		    		if(file.size> 1024*1024*2){
		    			toastr.error('裁剪后图片不得超过2M!');
		    			return;
		    		}
		    		//传给父组件的监听方法
		    		that.$emit('cropperImg', {file:file,src:url});

		    		that.resetModal();
		    	});
		    },
		    resetModal() {
		    	this.imgFile = null;
		    	this.showModal = false;
		    	this.$refs.imgInput.value = '';  //input的值清空
		    	$(this.$refs['img-cropper']).cropper('destroy'); // 销毁
		    }
		},
	}
</script>
<template>
	<div id="example-2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
        <table class="table table-bordered table-striped dataTable no-footer" id="example-2" role="grid" aria-describedby="example-2_info">
            <thead>
                <tr role="row">
                    <th v-for="(th,key) in ths"
                        @click="headClick(th,key)"
                        :class="[th.sortable ? 'sorting' : '', sortFiled===key ? 'sorting_'+(sortDesc?'desc':'asc') :'' ]"
                        :width="th.width ? th.width : '100px'"
                        rowspan="1" colspan="1" tabindex="0" arai-label
                    >
                        {{ th.label}}
                    </th>
                </tr>
            </thead>
            
            <tbody class="middle-align">   
            	<tr role="row" class="odd" v-for="item in lists">
                    <td v-for="(th,key) in ths">
                        <slot :name="key" :value="item[key]" :item="item"></slot>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="example-2_info" role="status" aria-live="polite">当前第{{ currenPage }}页，共{{ total }}条数据</div>
            </div>
            <pagination
                v-model="currenPage"
                :perPage="perPage"
                :total="total"
                :lastPage="lastPage"
            ></pagination>
        </div>
    </div>
</template>

<script type="text/javascript">
	require('datatables/dataTables.bootstrap.css');
	import Pagination from './Pagination.vue';
	export default {
		components : { Pagination },
		data() {
			return {
                lists: [],
                checkbox: false,
                perPage: 10,
                total: 0,
                lastPage: 0,
                currenPage: 1,
                sortFiled: null,
                sortDesc: true,
			}
		},
        // 监听翻页
        watch: {
            currenPage(val){
                this.loadList();
            }
        },
		mounted() {

			this.loadList();
		},
        methods:{
            headClick(field, key){

                if(!field.sortable) return;

                if(key === this.sortFiled)
                {
                    this.sortDesc = !this.sortDesc;
                }

                this.sortFiled = key;

                this.loadList();

            },
            loadList() {
                this.$Progress.start();

                let params={ page:this.currenPage , st_desc: this.sortDesc, st_field: this.sortFiled};

                if(typeof this.params !== 'undefined'){
                    params = Object.assign(params, this.params);
                }

                this.$axios({
                    type: 'get',
                    data: params,
                    url: this.ajaxUrl,
                    success: function(data){
                        let temp = data.list;
                        this.lists = temp.data;
                        this.perPage = parseInt(temp.per_page);
                        this.total = temp.total;
                        this.lastPage = temp.last_page;
                        this.currentPage = temp.current_page;
                        this.$Progress.finish();
                    },
                    fail:function(){

                    }

                });
            },
            onDel(id) {

                let _this = this;

                swal({}).then(function (res) {
                        if(res.value)
                        {
                            axios.delete(_this.del.url,{params: {user_id:id}})
                            .then((response)=>{

                                if(response.data.status == 1)
                                {
                                    toastr.success(response.data.msg);
                                    _this.loadList();
                                }else
                                {
                                    toastr.error(response.data.msg);
                                }
                            }).catch((error)=>{

                            });
                        }
                    });
            }
        },
        props: {
            ths: {
                type: Object,
                default: ()=> {}
            },

            ajaxUrl: {
                type: String,
                default: null
            },
            params: {
                type: Object,
                default: ()=>{}
            },
            del: {
                type: Object,
                default: ()=>{}
            }
        }
	}

</script>
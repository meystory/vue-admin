<template>
    <div class="col-xs-6">
        <div class="dataTables_paginate paging_simple_numbers"  v-if="lastPage>1">
            <ul class="pagination">
                <li 
                    :class="['paginate_button', 'previous',currentPage == 1?'disabled':'']" 
                    @click.prevent="(currentPage == 1) ? currentPage=1 : currentPage--"
                    aria-controls="example-2" tabindex="0" ><a href="#">上一页</a></li>
                <li 
                    v-for="(item, index) in pageRender"
                    :class="['paginate_button',(index+diff) === currentPage ? 'active' : 'hidden-xs-down']"
                    @click.prevent="currentPage = index + diff"
                    aria-controls="example-2" tabindex="0"><a href="#">{{ index+diff }}</a></li>


                <li :class="['paginate_button', 'next', currentPage == lastPage ? 'disabled': '']" 
                    @click.prevent="(currentPage == lastPage) ? (currentPage=lastPage) : currentPage++"
                    aria-controls="example-2" tabindex="0"><a href="#">下一页</a></li>
            </ul>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        data() {
            return {
                diff : 1,
                currentPage: this.value
            }
        },
        methods:{
            
        },
        computed:{
            pageRender() {
                let button_num = 7;

                this.diff = 1;

                if(this.lastPage <= button_num)
                {
                    return this.lastPage;
                }

                //上限
                if(this.currentPage >=this.lastPage-3)
                {
                    this.diff = this.lastPage-button_num+1;
                }

                if(this.currentPage > button_num- 3 &&  this.currentPage < this.lastPage-3)
                {
                    this.diff = this.currentPage-3;
                }

                return button_num;
            }
        },
        watch:{
            currentPage(newpage) {

                //触发Table.vue 组件的v-model:current_page 值改变
                this.$emit('input', newpage);
            },
        },
        props: {
            value: {
                type: Number,
                default: 1
            },
            perPage: {
                type: Number,
                default: 10
            },

            total: {
                type: Number,
                default: 0
            },
            lastPage: {
                type: Number,
                default: 0
            }
        }
    }
</script>
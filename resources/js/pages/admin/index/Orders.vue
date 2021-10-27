<template>
    <div>
        <v-container>
            <v-row >
                <v-col cols=12 :max-height="200">
                    <v-card class="">
                        <v-card-text>
                            <div class="d-flex">
                                <p class="text-h4 text--primary">
                                    ORDER #/
                                </p>
                                <p>adjective</p>
                                <div class="text--primary">
                                    well meaning and kindly.<br>
                                    "a benevolent smile"
                                </div>
                            </div>
                           
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="12">
                <v-container class="max-width">
                    <v-pagination
                    v-model="page"
                    class="my-4"
                    :length="pageNumbers"
                    ></v-pagination>
                </v-container>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    data : () =>({
        orders: [],
        page : 1,
        pageNumbers: 1,
        filters : ['on-the-way','assinged-to-driver', 'pending','delivered','accepted','denied','all'],
        active_filter : 'all'
    }),
    mounted () {
        this.initialize()
    },
    methods : {
        initialize(){
            let params = { 
                page: this.page,
                per_page: 10,
                filter : this.active_filter,
            } 

            this.$admin.get('/order/all', { params })
            .then(({data}) => {
                this.orders = data;
                 this.pageNumbers = data.last_page;
            });
        }
    },
    watch : {
        page (){
            this.initialize()
        },
        active_filter() {
            this.initialize()

        }
    }


    
}
</script>

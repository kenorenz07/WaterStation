<template>
    <div>
        <div class="d-flex justify-space-between mx-5 my-5">
            <v-card
                class="mx-auto"
                max-width="300"
                outlined
            >
                <v-list-item three-line>
                    <v-list-item-content>
                        <v-list-item-title class="text-h5 mb-1">
                            Customers
                        </v-list-item-title>
                        <v-list-item-subtitle>These are the current number of Customers using the app</v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-avatar
                        tile
                        size="80"
                    >
                        <v-icon
                            x-large
                            color="light-blue accent-3"
                        >
                            mdi-account-multiple
                        </v-icon>
                    </v-list-item-avatar>
                
                </v-list-item>

                <div class="d-flex justify-space-between">

                    <v-card-actions>
                        <v-btn
                            @click="$router.push('/customers')"
                            outlined
                            rounded
                            text
                        >
                            See Customers
                        </v-btn>
                    </v-card-actions>
                    <p class="text-h4 mb-1 pr-10">
                        {{statistics.customers}}
                    </p>
                </div>
            </v-card>
            <v-card
                class="mx-auto"
                max-width="344"
                outlined
            >
                <v-list-item three-line>
                    <v-list-item-content>
                        <v-list-item-title class="text-h5 mb-1">
                            Products
                        </v-list-item-title>
                        <v-list-item-subtitle>These are the current number of products using the app</v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-avatar
                        tile
                        size="80"
                    >
                         <v-icon
                            x-large
                            color="light-blue accent-3"
                        >
                            mdi-cup-water
                            
                        </v-icon>
                    </v-list-item-avatar>
                   
                </v-list-item>

                <div class="d-flex justify-space-between">

                    <v-card-actions>
                        <v-btn
                            @click="$router.push('/products')"
                            outlined
                            rounded
                            text
                        >
                            See Products
                        </v-btn>
                    </v-card-actions>
                    <p class="text-h4 mb-1 pr-10">
                        {{statistics.products}}
                    </p>
                </div>
            </v-card>
                   <v-card
                class="mx-auto"
                max-width="344"
                outlined
            >
                <v-list-item three-line>
                    <v-list-item-content>
                        <v-list-item-title class="text-h5 mb-1">
                            Orders
                        </v-list-item-title>
                        <v-list-item-subtitle>These are the current number of Orders using the app</v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-avatar
                        tile
                        size="80"
                    >
                         <v-icon
                            x-large
                            color="light-blue accent-3"
                        >
                            mdi-car
                            
                        </v-icon>
                    </v-list-item-avatar>
                   
                </v-list-item>

                <div class="d-flex justify-space-between">

                    <v-card-actions>
                        <v-btn
                            @click="$router.push('/orders')"
                            outlined
                            rounded
                            text
                        >
                            See Orders
                        </v-btn>
                    </v-card-actions>
                    <p class="text-h4 mb-1 pr-10">
                        {{statistics.orders}}
                    </p>
                </div>
            </v-card>
        </div>
        <v-card
            class="mx-5 my-5"
        >
            <template slot="progress">
                <v-progress-linear
                    color="light-blue accent-2"
                    height="5"
                    indeterminate
                ></v-progress-linear>
            </template> 

            <div>
                <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
            </div>
        </v-card>
    </div>
</template>
<script>
    export default {
        data : () => ({
            year: new Date().getFullYear() ,
            statistics: {},
            loading: false,
            series: [
                {
                    name: "Quantity",
                    data: [1,0,2,0,3,0,5,0,6,0,5,0]
                }
            ],
            chartOptions: {
                chart: {
                    height: 350,
                    type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: true
                    }
                },
                colors: ['#77B6EA', '#545454'],
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: 'smooth'
                },
                title: {
                    text: 'Sales',
                    align: 'left'
                },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sept','Oct', 'Nov','Dec'],
                    title: {
                        text: 'Month'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Sales'
                    },
                    min: 5,
                    max: 60
                },
                legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
                }
            },
        }),
        created() {
            this.getStatictics()
        },
        methods: {
            getStatictics(){

                this.$admin.get('dashboard-statistics/'+this.year).then(({data}) => {
                    this.statistics = data
                    this.series = [{
                        name: "Quantity",
                        data: data.sales[0]
                        // data: data.sales
                    }]
                    this.chartOptions ={
                        yaxis :{
                            title: {
                                text: 'Sales'
                            },
                            min: data.sales[1],
                            max: data.sales[2]
                        }
                    }

                })
            },
            reserve () {

            },
        }
    }
</script>
<style lang="scss" scoped>
    .v-icon.v-icon {
        font-size: 80px!important;
    }
</style>
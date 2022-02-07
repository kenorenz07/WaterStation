<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
        <v-card-title>
            Delivery Sales
        <v-spacer></v-spacer>
        <div>
            <v-menu
                v-model="date_pick"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="auto"
            >
                <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="date_filter"
                    label="Select Date"
                    prepend-icon="mdi-calendar"
                    readonly
                        color="light-blue"
                    v-bind="attrs"
                    v-on="on"
                ></v-text-field>
                </template>
                <v-date-picker
                    color="light-blue"
                    v-model="date_filter"
                    @input="date_pick = false"
                ></v-date-picker>
            </v-menu>  
        </div>
        <div class="mx-4 pb-3">
            <v-select
                :items="delivery_men"
                v-model="filter_delivery_men"
                label="Select delivery_man/s"
                item-text="name"
                item-value="id"
                class="multi-select-del"
                max-height="auto"
                autocomplete
                multiple
                chips
            >
                <template v-slot:prepend-item>
                    <v-list-item
                        ripple
                        @click="toggleFilter"
                    >
                        <v-list-item-action>
                            <v-icon :color="filter_delivery_men.length > 0 ? 'indigo darken-4' : ''">
                                {{ filter_icon_selected }}
                            </v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                                Select All
                            </v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                    <v-divider class="mt-2"></v-divider>
                </template>
            </v-select>
        </div>
        <h6 class="mx-5">
            TOTAL SALES: ₱{{grand_total}}
        </h6> 
        <v-btn class="ml-2" @click="generateDialog = true">
            Generate Report
        </v-btn>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :page="page"
        :pageCount="numberOfPages"
        :headers="headers"
        :items="sales"
        :options.sync="options"
        :server-items-length="total"
        :items-per-page="options.itemsPerPage"
        @update:options="initialize"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.customer_name="{ item }">
            {{item.user.name}}
        </template>
        <template v-slot:item.delivery_name="{ item }">
            {{item.delivery_man.name}}
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
          @click="modalPop(item)"
          >
            mdi-eye
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <SalesForm :order="sales_to_show" :dialogState="sales_dialog" @close="sales_dialog = false" />
       <v-dialog
            v-model="generateDialog"
            persistent
            max-width="400px"
            >
            
            <v-card>
                <v-card-title>
                    <span class="text-h5">Select Filter for Sales Report</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col >   
                               
                                <label for="">Filter start to end date</label>
                                <div>
                                    <v-date-picker
                                        color="light-blue"
                                        @input="generate_date_pick = false"
                                        v-model="generate_dates"
                                        range
                                    ></v-date-picker>
                                </div>
                            </v-col>
                            <v-col >   
                               
                                <label for="">Filter Delivery men</label>
                                <div>
                                    <v-select
                                        :items="delivery_men"
                                        v-model="generate_by_delivery_men"
                                        label="Select delivery_man/s"
                                        item-text="name"
                                        item-value="id"
                                        max-height="auto"
                                        autocomplete
                                        multiple
                                        chips
                                    >
                                        <template v-slot:prepend-item>
                                            <v-list-item
                                                ripple
                                                @click="toggle"
                                            >
                                                <v-list-item-action>
                                                    <v-icon :color="generate_by_delivery_men.length > 0 ? 'indigo darken-4' : ''">
                                                        {{ icon_selected }}
                                                    </v-icon>
                                                </v-list-item-action>
                                                <v-list-item-content>
                                                    <v-list-item-title>
                                                        Select All
                                                    </v-list-item-title>
                                                </v-list-item-content>
                                                </v-list-item>
                                            <v-divider class="mt-2"></v-divider>
                                        </template>
                                    </v-select>
                                </div>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="generateDialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        :disabled="generate_by_delivery_men.length < 1"
                        @click="downloadPDF"
                    >
                        Generate
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
</div>
</template>

<script>
import SalesForm from '../../../components/adminForms/Sales.vue'
  export default {
    components: {
        SalesForm
    },
    data() {
      return {
        page: 0,
        total: 0,
        grand_total: 0,
        numberOfPages: 0,
        sales: [],
        loading: true,
        sales_dialog : false,
        options: {
          itemsPerPage: 10
        },
        footerProps :{
          "items-per-page-options" : [5,10,15, 30, ]
        },
        headers: [
          { text: "Customer Name", value: "customer_name" },
          { text: "Delivery Man", value: "delivery_name" },
          { text: "Sub Total (php)", value: "total" },
          { text: "Date Delivered", value: "date_delivered" },
          { text: "Time Delivered", value: "time_delivered" },
          { text: "Actions", value: "actions" },
        ],
        date_pick: false,
        date_filter: (new Date()).toISOString().split('T')[0],
        sales_to_show : {},
        filter_delivery_men  : [],

        generateDialog: false,
        generate_date_pick: false,
        generate_dates: [(new Date()).toISOString().split('T')[0],(new Date(new Date().getTime()+(14*24*60*60*1000))).toISOString().split('T')[0]],
        generate_by_delivery_men : [],
        delivery_men : [],
      };
  },
  //this one will populate new data set when user changes current page. 
  watch: {
    // options: {
    //   handler(val) {
    //     // if(val.page != 0)
    //         this.initialize() 
    //   },
    //     deep: true
    // },
    date_filter (val) {
        if(val != (new Date()).toISOString().split('T')[0])
            this.initialize()
    },
    filter_delivery_men (val) {
        if(val != [])
            this.initialize()
    } 
  },
  computed : {
    selectsAll () {
        return this.generate_by_delivery_men.length === this.delivery_men.length
    },
    selectSome () {
        return this.generate_by_delivery_men.length > 0 && !this.selectsAll
    },
    icon_selected () {
        if (this.selectsAll) return 'mdi-close-box'
        if (this.selectSome) return 'mdi-minus-box'
        return 'mdi-checkbox-blank-outline'
    },
    filter_selectsAll () {
        return this.filter_delivery_men.length === this.delivery_men.length
    },
    filter_selectSome () {
        return this.filter_delivery_men.length > 0 && !this.selectsAll
    },
    filter_icon_selected () {
        if (this.filter_selectsAll) return 'mdi-close-box'
        if (this.filter_selectSome) return 'mdi-minus-box'
        return 'mdi-checkbox-blank-outline'
    },
  },
  methods: {
    //Reading data from API method. 
    initialize() {
        this.loading = true;
        const { page, itemsPerPage } = this.options;
        let params = { 
            page: page,
            per_page: itemsPerPage,
            date_filter : this.date_filter,
            filter_delivery_men : JSON.stringify(this.filter_delivery_men)

        } 
        this.$admin.get('/sales/all', { params })
          .then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.sales = data.sales.data;
            console.log(data)
            this.grand_total = data.grandtotal
            this.loading = false;
            this.page = data.sales.page;
            this.total = data.sales.total;
            this.numberOfPages = data.sales.last_page;
          });
    },
    getDeliveryMen() {
        this.$admin.get('/delivery-man/all').then(({data}) => {
            this.delivery_men = data.map((delivery_man) => {
                return {
                    id : delivery_man.id,
                    name : delivery_man.name,
                }
            })
            this.filter_delivery_men = this.delivery_men.map((delivery_man) => {
                return delivery_man.id
            })
        })
    },
    toggleFilter() {
        this.$nextTick(() => {
            if (this.filter_selectsAll) {
                console.log('gsgs')
                this.filter_delivery_men = []
            } else {
                console.log('aaa')
                this.filter_delivery_men = this.delivery_men.map((delivery_man) => {
                    return delivery_man.id
                })
            }
        })
    },
    toggle () {
        this.$nextTick(() => {
            if (this.selectsAll) {
                console.log('gsgs')
                this.generate_by_delivery_men = []
            } else {
                console.log('aaa')
                this.generate_by_delivery_men = this.delivery_men.map((delivery_man) => {
                    return delivery_man.id
                })
            }
        })
    },
    
    modalPop(sales){
        this.sales_to_show = {
            created_at: sales.created_at, 
            date_delivered: sales.date_delivered, 
            delivery_man: sales.delivery_man, 
            delivery_man_id: sales.delivery_man_id, 
            id: sales.id, 
            orders: JSON.parse(sales.orders), 
            time_delivered: sales.time_delivered, 
            total: sales.total, 
            updated_at: sales.updated_at, 
            user: sales.user, 
            user_id: sales.user_id, 
        }
        this.sales_to_show.orders = JSON.parse(sales.orders)
        this.sales_dialog = true
    },
      downloadPDF()
      {
          this.$admin.get('/sales/generate-pdf/'+this.generate_dates[0]+'/'+this.generate_dates[1]+'/'+JSON.stringify(this.generate_by_delivery_men),{
              responseType: 'arraybuffer'
          })
          .then(response => {
              const url = window.URL.createObjectURL(new Blob([response.data]));
              const link = document.createElement('a');
              link.href = url;
              link.setAttribute('download', 'DELSALESREPORT'+this.generate_dates[0]+'-'+this.generate_dates[1]+'.pdf');
              document.body.appendChild(link);
              link.click();
              // let blob = new Blob([response.data], { type: 'application/pdf' }),
              // url = window.URL.createObjectURL(blob)

              // window.open(url) // Mostly the same, I was just experimenting with different approaches, tried link.click, iframe and other solutions
        })
      }
  },
  
  //this will trigger in the onReady State
  mounted() {
    this.initialize();
    this.getDeliveryMen();
  },
  }
</script>
<style lang="scss">
 .multi-select-del{
    max-width: 300px;
 }
</style>
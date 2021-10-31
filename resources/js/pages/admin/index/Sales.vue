<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
        <v-card-title>
            Sales
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
                    label="Select "
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
          { text: "Customer name", value: "customer_name" },
          { text: "Delivery man username", value: "delivery_name" },
          { text: "Total (PHP)", value: "total" },
          { text: "Date delivered", value: "date_delivered" },
          { text: "Time delivered", value: "time_delivered" },
          { text: "Actions", value: "actions" },
        ],
        date_pick: false,
        date_filter: (new Date()).toISOString().split('T')[0],
        sales_to_show : {}
      };
  },
  //this one will populate new data set when user changes current page. 
  watch: {
    options: {
      handler(val) {
        this.initialize() 
      },
        deep: true
    },
    date_filter (val) {
        this.initialize()
    } 
  },
  methods: {
    //Reading data from API method. 
    initialize() {
        this.loading = true;
        const { page, itemsPerPage } = this.options;
        let params = { 
            page: page,
            per_page: itemsPerPage,
            date_filter : this.date_filter

        } 
        this.$admin.get('/sales/all', { params })
          .then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.sales = data.data;
            this.page = data.page;
            this.total = data.total;
            this.numberOfPages = data.last_page;
          });
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
    }
  },
  
  //this will trigger in the onReady State
  mounted() {
    this.initialize();
  },
  }
</script>
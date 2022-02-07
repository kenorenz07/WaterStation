<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title>
        Products
      <v-spacer></v-spacer>
       <v-text-field
            v-model="search_key"
            append-icon="mdi-magnify"
            label="Search"
            class="shrink mr-5"
            single-line
            hide-details
        ></v-text-field>
        <v-icon
          large
          @click="addProduct"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :page="page"
        :pageCount="numberOfPages"
        :headers="headers"
        :items="products"
        :options.sync="options"
        :server-items-length="total"
        :items-per-page="options.itemsPerPage"
        @update:options="initialize"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.is_refill="{ item }">
          <v-switch
            color="light-blue "
            v-model="item.is_refill"
            @click="changeRefillState(item)"
          ></v-switch>
        </template>
        <template v-slot:item.created_at="{ item }">
          {{moment(item.created_at).format("MMM Do YYYY")  }}
        </template>
        <template v-slot:item.updated_at="{ item }">
          {{moment(item.updated_at).format("MMM Do YYYY")  }}
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            class="mr-2"
            @click="editProduct(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="confirmDialog = true,deletion_id = item.id"

          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <ProductForm :form="productForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveProduct()" />
    <Confirmation :dialogState="confirmDialog" @close="confirmDialog = false" @confirm="deleteProduct"/>

</div>
</template>
<script>
  import Confirmation from '../../../components/Confirm.vue'
  import ProductForm from '../../../components/adminForms/Product.vue'
  export default {
    components: {
      ProductForm,Confirmation
    },
    data() {
      return {
        confirmDialog:false,
        deletion_id: null,
        page: 0,
        total: 0,
        numberOfPages: 0,
        products: [],
        loading: true,
        options: {
          itemsPerPage: 10
        },
        footerProps :{
          "items-per-page-options" : [5,10,15, 30, ]
        },
        headers: [
          { text: "Product Name", value: "name" },
          { text: "Description", value: "description" },
          { text: "For Refill", value: "is_refill" },
          { text: "Price (₱)", value: "price" },
          { text: "Created At", value: "created_at" },
          { text: "Updated At", value: "updated_at" },
          { text: "Actions", value: "actions" },
        ],
        addition_edition_dailog: false,
        productForm: {
          id:null,
          description:'',
          is_refill: true,
          price: 0.0,
          image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        },
        search_key : '',
      };
  },
  //this one will populate new data set when user changes current page. 
  watch: {
    options: {
      handler(val) {
        this.initialize() 
      },
    },
    search_key : {
          handler(val){
              this.initialize()
          }
      }
  },
  methods: {
    //Reading data from API method. 
    initialize() {
        this.productForm = {
          id:null,
          description:'',
          is_refill: true,
          price: 0.0,
          image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        const { page, itemsPerPage } = this.options;
        let params = { 
          page: page,
          per_page: itemsPerPage,
          search_key: this.search_key
        } 
        this.$admin.get('/product/all', { params })
          .then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.products = data.data;
            this.page = data.page;
            this.total = data.total;
            this.numberOfPages = data.last_page;
          });
    },
    
    changeRefillState(product){
      this.productForm = {
        id: product.id,
        name: product.name ,
        description: product.description ,
        is_refill: product.is_refill ,
        price: product.price ,
        image: '/storage/'+product.image 
      }

      this.saveProduct()
    },
    addProduct(){
      this.productForm = {
        id:null,
        description:'',
        is_refill: true,
        price: 0.0,
        image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editProduct(product){
      this.productForm = {
        id: product.id,
        name: product.name ,
        description: product.description ,
        is_refill: product.is_refill ,
        price: product.price ,
        image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveProduct(){
      if(this.productForm.id){
        this.$admin.put('/product/update/'+this.productForm.id,this.productForm).then(({data}) => {
          this.initialize()
        })
      }
      else{
        this.$admin.post('/product/create',this.productForm).then(({data}) =>{
      
          this.initialize()
        })
      }
    },
    deleteProduct(){
      this.confirmDialog = false
      this.$admin.delete('/product/delete/'+ this.deletion_id).then(({data}) => {
        if(data.error) {
          alert(data.error);
        }
        this.initialize() 
        this.deletion_id = null
      })
    }
  },
  
  //this will trigger in the onReady State
  mounted() {
    this.initialize();
  },
  }
</script>
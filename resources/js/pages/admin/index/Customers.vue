<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title>
        Customers
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addUser"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :page="page"
        :pageCount="numberOfPages"
        :headers="headers"
        :items="users"
        :options.sync="options"
        :server-items-length="total"
        :items-per-page="options.itemsPerPage"
        @update:options="initialize"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.image="{ item }">
            <v-avatar color="light-blue">
                <img v-if="item.image"
                    :src="'/storage/' + item.image"
                >
                <v-icon v-else dark>
                    mdi-account-circle
                </v-icon>
            </v-avatar>
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
            @click="editUser(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteUser(item)"

          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <UserForm :form="userForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveUser()" />

</div>
</template>
<script>
  import UserForm from '../../../components/adminForms/Customer.vue'
  export default {
    components: {
      UserForm
    },
    data() {
      return {
        page: 0,
        total: 0,
        numberOfPages: 0,
        users: [],
        loading: true,
        options: {
          itemsPerPage: 10
        },
        footerProps :{
          "items-per-page-options" : [5,10,15, 30 ]
        },
        headers: [
            { text: "Image", value: "image" },
            { text: "Name", value: "name" },
            { text: "Email", value: "email" },
            { text: "Phone Number", value: "phone_number" },
            { text: "Created At", value: "created_at" },
            { text: "Updated At", value: "updated_at" },
            { text: "Actions", value: "actions" },
        ],
        addition_edition_dailog: false,
        userForm: {
          id:null,
          name:'',
          email: '',
          phone_number: '',
          password: '',
          image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
      };
    },
    //this one will populate new data set when user changes current page. 
    watch: {
    
    },
    methods: {
        //Reading data from API method. 
        initialize() {
            this.userForm = {
                id:null,
                name:'',
                email: '',
                phone_number: '',
                password: '',
                image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
            }
            this.loading = true;
            const { page, itemsPerPage } = this.options;
            let params = { 
            page: page,
            per_page: itemsPerPage
            } 
            this.$admin.get('/user/all', { params })
            .then(({data}) => {
                //Then injecting the result to datatable parameters.
                this.loading = false;
                this.users = data.data;
                this.page = data.page;
                this.total = data.total;
                this.numberOfPages = data.last_page;
            });
        },
        addUser(){
            this.userForm = {
                id:null,
                name:'',
                email: '',
                phone_number: '',
                password: '',
                image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
            }
        this.addition_edition_dailog = true
        },
        editUser(user){
            this.userForm = {
                id:user.id,
                name:user.name,
                email:user.email ,
                phone_number:user.phone_number ,
                image: '/storage/'+user.image,
            }
            this.addition_edition_dailog = true
        },
        saveUser(){
            if(this.userForm.id){
                    this.$admin.put('/user/update/'+this.userForm.id,this.userForm).then(({data}) => {
                        this.initialize()
                    })
            }
            else{
                this.$admin.post('/user/create',this.userForm).then(({data}) =>{
                    this.initialize()
                })
            }
        },
        deleteUser(user){
            this.$admin.delete('/user/delete/'+ user.id).then(({data}) => {
                this.initialize() 
            })
        }
    },  
        
    mounted() {
        this.initialize();
    },
  }
</script>
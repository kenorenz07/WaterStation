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
            @click="confirmDialog = true,deletion_id = item.id"

          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <UserForm :form="userForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveUser()" />
    <Confirmation :dialogState="confirmDialog" @close="confirmDialog = false" @confirm="deleteUser"/>

</div>
</template>
<script>
  import Confirmation from '../../../components/Confirm.vue'
  import UserForm from '../../../components/adminForms/Customer.vue'
  export default {
    components: {
      UserForm,Confirmation
    },
    data() {
      return {
        confirmDialog:false,
        deletion_id: null,
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
          purok : '',
          brgy : '',
          additional_address : '',
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
                purok : '',
                brgy : '',
                additional_address : '',
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
                purok : '',
                brgy : '',
                additional_address : '',
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
                purok : user.purok,
                brgy : user.brgy,
                additional_address : user.additional_address,
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
        deleteUser(){
            this.confirmDialog = false
            this.$admin.delete('/user/delete/'+ this.deletion_id).then(({data}) => {
                if(data.error) {
                  alert(data.error);
                }
                this.initialize() 
                this.deletion_id = null
            })
        }
    },  
        
    mounted() {
        this.initialize();
    },
  }
</script>
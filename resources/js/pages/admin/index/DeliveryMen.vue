<template>
    <div class="mx-2 my-2">
        <div class="d-flex  justify-space-between">
            <p class="text-h6">DELIVERY MEN</p>
            <div class="mr-5">
                <v-btn
                    icon large
                    color="light-blue"
                    @click="addition_dailog = true"
                >
                    <v-icon>mdi-account-multiple-plus-outline</v-icon>
                </v-btn>
            </div>
        </div>
        <v-container fluid>
            <v-row dense>
                <v-col
                v-for="deliver_man in deliverMen"
                :key="deliver_man.id"
                :cols="4"
                >
                    <v-card
                    
                        max-width="1/3"
                        rounded
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5 mb-1">
                                    {{deliver_man.name}}
                                </v-list-item-title>
                                <v-list-item-subtitle>Username: {{deliver_man.username}}</v-list-item-subtitle>
                                <v-list-item-subtitle>Created At: {{moment(deliver_man.created_at).format("MMM Do YYYY") }}</v-list-item-subtitle>
                                <v-list-item-subtitle>Updated at : {{moment(deliver_man.created_at).format("MMM Do YYYY") }}</v-list-item-subtitle>
  
                            </v-list-item-content>

                            <v-list-item-avatar
                                size="100" 
                            >
                                <v-img :src="deliver_man.image ? '/storage/'+deliver_man.image :'https://scontent.fceb1-2.fna.fbcdn.net/v/t1.6435-9/241439838_4465586350227792_3670855029139333701_n.jpg?_nc_cat=111&ccb=1-5&_nc_sid=09cbfe&_nc_eui2=AeF3vyn6YvL9o1RF9fGnpHCjWVrCGOG7wZFZWsIY4bvBkcuCY4vL-sgWetXe4FVS5q5nvK7CV6lfTNWNPwxOaLee&_nc_ohc=F9LuBllnMx8AX9eLgoc&_nc_ht=scontent.fceb1-2.fna&oh=8611d72f1b6b04d769a3f1436724f47f&oe=616A7C39'"></v-img>
                            </v-list-item-avatar>
                        </v-list-item>

                        <v-card-actions>
                            <v-row class="px-2">
                                <v-col cols="7">
                                    <p class="text-h4 mb-1">{{deliver_man.orders ? deliver_man.orders.length : 0}}</p>
                                </v-col>
                                <v-col cols="2">
                                   <v-btn
                                        icon
                                        @click="confirmDialog = true,deletion_id = deliver_man.id"
                                        color="red"
                                    >
                                        <v-icon dark>
                                            mdi-delete
                                        </v-icon>
                                    </v-btn>
                                </v-col>
                                <v-col cols="3">
                                    <div class="d-flex">
                                        
                                        <v-btn
                                            icon
                                            @click="$router.push('/delivery-man/'+deliver_man.id)"
                                            color="light-blue"
                                        >
                                            <v-icon dark>
                                                mdi-eye
                                            </v-icon>
                                        </v-btn>
                                    </div>
                                 
                                </v-col>
                            </v-row>
                            
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <DeliveryManForm :form="deliveryManForm" :dialogState="addition_dailog" @close="addition_dailog = false" @save="addition_dailog = false,saveDeliveryMan()" />
        <Confirmation :dialogState="confirmDialog" @close="confirmDialog = false" @confirm="deleteDeliveryMan"/>
    </div>
</template>
<script>
    import DeliveryManForm from '../../../components/adminForms/DeliveryMan.vue'
  import Confirmation from '../../../components/Confirm.vue'
    export default {
        components : {
            DeliveryManForm,Confirmation
        },
        data: () => ({
            addition_dailog: false,
            deletion_id: null,
            confirmDialog : false,
            deliveryManForm : {
                name:'',
                username: '',
                password: '',
                phone_number: '',
                image: '',
            },
            deliverMen : [],
        }),
        created(){
            this.initialize()
        },
        methods : { 
            initialize(){
                this.$admin.get('/delivery-man/all').then(({data}) => {
                    this.deliverMen = data
                })
            },
            saveDeliveryMan () {
                this.$admin.post('/delivery-man/create',this.deliveryManForm).then(({data}) =>{
                    this.deliveryManForm = {
                        name:'',
                        username: '',
                        password: '',
                        phone_number: '',
                        image: '',
                    }
                    this.initialize()
                })
            },
            deleteDeliveryMan () {
                this.confirmDialog = false
                this.$admin.delete('/delivery-man/delete/'+this.deletion_id).then(({data}) => {
                    this.initialize()
                    this.deletion_id = null

                })
            },
        }
    }
</script>
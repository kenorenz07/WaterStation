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
                :key="deliver_man.title"
                :cols="4"
                >
                    <v-card
                    
                        max-width="1/3"
                        rounded
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5 mb-1">
                                    John Doe
                                </v-list-item-title>
                                <v-list-item-subtitle>Username: delivery_man01</v-list-item-subtitle>
                                <v-list-item-subtitle>Orders taken :</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-avatar
                                size="100" rounded
                            >
                                <v-img src="https://scontent.fceb1-2.fna.fbcdn.net/v/t1.6435-9/241439838_4465586350227792_3670855029139333701_n.jpg?_nc_cat=111&ccb=1-5&_nc_sid=09cbfe&_nc_eui2=AeF3vyn6YvL9o1RF9fGnpHCjWVrCGOG7wZFZWsIY4bvBkcuCY4vL-sgWetXe4FVS5q5nvK7CV6lfTNWNPwxOaLee&_nc_ohc=F9LuBllnMx8AX9eLgoc&_nc_ht=scontent.fceb1-2.fna&oh=8611d72f1b6b04d769a3f1436724f47f&oe=616A7C39"></v-img>
                            </v-list-item-avatar>
                        </v-list-item>

                        <v-card-actions>
                            <v-row class="px-2">
                                <v-col cols="6">
                                    <p class="text-h4 mb-1">53</p>
                                </v-col>
                                <v-col cols="3"></v-col>
                                <v-col cols="3">
                                    <v-btn
                                        icon
                                        
                                        color="light-blue"
                                    >
                                        <v-icon dark>
                                            mdi-eye
                                        </v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                            
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <DeliveryManForm :form="deliveryManForm" :dialogState="addition_dailog" @close="addition_dailog = false" @save="addition_dailog = false" />
    </div>
</template>
<script>
    import DeliveryManForm from '../../../components/adminForms/DeliveryMan.vue'
    export default {
        components : {
            DeliveryManForm
        },
        data: () => ({
            addition_dailog: false,
            deliveryManForm : {
                name:'',
                username: '',
                password: '',
                phone_number: '',
                image: '',
            },
            deliverMen : [
                {
                    title: 'gs'
                },
                {
                    title: 'gs'
                },
                { 
                    title: 'gs'
                },
                {
                    title: 'gs'
                },
                {
                    title: 'gs'
                },
                { 
                    title: 'gs'
                },
            ],
        }),
    }
</script>
<template>
  <v-container>
    <v-row justify="space-around">
      <v-card width="100%" color="light-blue lighten-2">
        <div class="d-flex justify-content-between my-7 mx-5">

          <div class="white--text d-flex  mt-5">
            <v-avatar size="100" >
                <v-img :src="deliveryMan.image ? '/storage/'+deliveryMan.image :'https://scontent.fceb1-2.fna.fbcdn.net/v/t1.6435-9/241439838_4465586350227792_3670855029139333701_n.jpg?_nc_cat=111&ccb=1-5&_nc_sid=09cbfe&_nc_eui2=AeF3vyn6YvL9o1RF9fGnpHCjWVrCGOG7wZFZWsIY4bvBkcuCY4vL-sgWetXe4FVS5q5nvK7CV6lfTNWNPwxOaLee&_nc_ohc=F9LuBllnMx8AX9eLgoc&_nc_ht=scontent.fceb1-2.fna&oh=8611d72f1b6b04d769a3f1436724f47f&oe=616A7C39'"></v-img>
            </v-avatar>
            <div>
                <div class="d-flex ">
                    <p class="ml-3">
                        Name: {{deliveryMan.name}}
                    </p>
               
                </div>
          
                <p class="ml-3 mb-0 pt-0">
                Username : {{deliveryMan.username}}
                </p>
                <p class="ml-3 mb-0 pt-0">
                Phone Number {{deliveryMan.phone_number}}
                </p>
            </div>
          </div>
          <v-btn
            @click="update_dailog = true"
            icon
          >
            <v-icon dark>
              mdi-pencil
            </v-icon>
          </v-btn>
        </div>
        <v-divider elevation="10"></v-divider>
          <v-card-text>
             <v-data-table
              :items-per-page='5'
              dense
              :headers="headers"
              :items="orders"
              item-key="name"
              class="elevation-1"
            ></v-data-table>
          </v-card-text>
      </v-card>
    </v-row>
    <DeliveryManForm :form="deliveryManForm" :dialogState="update_dailog" @close="update_dailog = false" @save="update_dailog = false,updateDeliveryMan()" />
  </v-container>
</template>
<script>
    import DeliveryManForm from '../../../components/adminForms/DeliveryMan.vue'
    export default {
      components : {
          DeliveryManForm
      },
      data: () => ({
          deliveryMan: {},
          deliveryManForm : {},
          update_dailog: false,

          orders: [],
          headers: [
            {
              text: 'Customer',
              align: 'start',
              sortable: false,
              value: 'customer_name',
            },
            { text: 'Status', value: 'status' },
            { text: 'Total', value: 'total' },
          ],
      }),
      mounted () {
          this.initialize()
      },
      methods : { 
          initialize(){
              console.log(this.$route.params.id);
              this.$admin.get('/delivery-man/show/'+this.$route.params.id).then(({data}) => {
                  this.deliveryMan = data.delivery_man

                  this.deliveryManForm = { 
                      id: data.delivery_man.id,
                      name: data.delivery_man.name,
                      username: data.delivery_man.username,
                      phone_number: data.delivery_man.phone_number,
                      image: '/storage/'+data.delivery_man.image,
                  }

                  this.orders = data.orders.map(function (order) {
                    return {
                      'customer_name' : order.user.name,
                      'status' : order.status,
                      'total' : order.total,
                    }
                  })


              })
          },
          updateDeliveryMan() {
              this.$admin.put('/delivery-man/update/'+this.$route.params.id,this.deliveryManForm).then(({data}) => {
                  this.initialize()
              })
          }
      }
  }
</script>
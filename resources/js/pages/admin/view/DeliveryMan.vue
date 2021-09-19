<template>
  <v-container>
    <v-row justify="space-around">
      <v-card width="1000">
        <v-img
          height="170px"
          src="https://www.pngmagic.com/product_images/solid-light-blue-background.jpg"
        >

          <v-card-title class="white--text mt-5">
            <v-avatar size="100" tile>
                <v-img :src="deliveryMan.image ? '/storage/'+deliveryMan.image :'https://scontent.fceb1-2.fna.fbcdn.net/v/t1.6435-9/241439838_4465586350227792_3670855029139333701_n.jpg?_nc_cat=111&ccb=1-5&_nc_sid=09cbfe&_nc_eui2=AeF3vyn6YvL9o1RF9fGnpHCjWVrCGOG7wZFZWsIY4bvBkcuCY4vL-sgWetXe4FVS5q5nvK7CV6lfTNWNPwxOaLee&_nc_ohc=F9LuBllnMx8AX9eLgoc&_nc_ht=scontent.fceb1-2.fna&oh=8611d72f1b6b04d769a3f1436724f47f&oe=616A7C39'"></v-img>
            </v-avatar>
            <div>
                <div class="d-flex justify-content-between">
                    <p class="ml-3">
                        Name: {{deliveryMan.name}}
                    </p>
                    <v-btn
                        color="light-blue text-white"
                        @click="update_dailog = true"
                    >
                        UPDATE
                    </v-btn>
                </div>
          
                <p class="ml-3 mb-0 pt-0">
                Username : {{deliveryMan.username}}
                </p>
                <p class="ml-3 mb-0 pt-0">
                Phone Number {{deliveryMan.phone_number}}
                </p>
            </div>
          </v-card-title>
        </v-img>

        <v-card-text>
          <div class="font-weight-bold ml-8 mb-2">
            Today
          </div>

          <v-timeline
            align-top
            dense
          >
            <v-timeline-item
              v-for="message in messages"
              :key="message.time"
              :color="message.color"
              small
            >
              <div>
                <div class="font-weight-normal">
                  <strong>{{ message.from }}</strong> @{{ message.time }}
                </div>
                <div>{{ message.message }}</div>
              </div>
            </v-timeline-item>
          </v-timeline>
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
        messages: [
            {
            from: 'You',
            message: `Sure, I'll see you later.`,
            time: '10:42am',
            color: 'deep-purple lighten-1',
            },
            {
            from: 'John Doe',
            message: 'Yeah, sure. Does 1:00pm work?',
            time: '10:37am',
            color: 'green',
            },
            {
            from: 'You',
            message: 'Did you still want to grab lunch today?',
            time: '9:47am',
            color: 'deep-purple lighten-1',
            },
        ],
        update_dailog: false,
    }),
    mounted () {
        this.initialize()
    },
    methods : { 
        initialize(){
            console.log(this.$route.params.id);
            this.$admin.get('/delivery-man/show/'+this.$route.params.id).then(({data}) => {
                this.deliveryMan = data

                this.deliveryManForm = { 
                    id: data.id,
                    name: data.name,
                    username: data.username,
                    phone_number: data.phone_number,
                    image: data.image,
                }
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
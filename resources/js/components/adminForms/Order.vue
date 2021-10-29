<template>
  <v-row justify="center">
    <v-dialog
      v-model="orderDialog"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">Update Status</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
                <v-col      
                    cols="12"
                    sm="12"
                    md="12"
                >   
                <!-- 'on-the-way','assigned-to-driver', 'pending','delivered','accepted','denied' -->
                    <div v-if="order.status == 'pending'">
                        <v-btn
                            block
                            class="accepted text-white mt-2"
                            @click="updateOrderStatus('accepted')"
                        >
                            Accept
                        </v-btn>
                        <v-btn
                            block
                            class="denied text-white mt-2"
                            @click="updateOrderStatus('denied')"
                        >
                            Decline
                        </v-btn>
                    </div>
                    <div v-else-if="order.status == 'accepted'">
                        <v-select
                            v-model="deliveryMan"
                            :items="deliverMen"
                            item-text="name"
                            item-value="id"
                            label="Assign order to a delivery man"
                        ></v-select>
                        <v-btn
                            block
                            class="accepted text-white mt-2"
                            @click="setDeliveryMan"
                        >
                            Update
                        </v-btn>
                    </div>
                    <div v-else-if="order.status == 'assigned-to-driver'">
                        <!-- <label for="">Date</label> -->
                        <v-menu
                            ref="time_pick"
                            v-model="time_pick"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            :return-value.sync="time_filter"
                            transition="scale-transition"
                            offset-y
                            max-width="290px"
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="time_filter"
                                label="Select time to deliver"
                                prepend-icon="mdi-clock-time-four-outline"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                            </template>
                            <v-time-picker
                            v-if="time_pick"
                            v-model="time_filter"
                            full-width
                            @click:minute="$refs.time_pick.save(time_filter)"
                            ></v-time-picker>
                        </v-menu>
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
                                    label="Select date to deliver"
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
                        <v-btn
                            block
                            class="assigned-to-driver text-white mt-2"
                            @click="setDateAndTimeToDeliver"
                        >
                            Update
                        </v-btn>
                    </div>
                    <div v-else>
                        <v-btn
                            block
                            class="on-the-way text-white mt-2"
                            @click="updateOrderStatus('on-the-way')"
                        >
                            ON THE WAY
                        </v-btn>
                        <v-btn
                            block
                            class="delivered text-white mt-2"
                            @click="updateOrderStatus('delivered')"
                        >
                            DELIVERED
                        </v-btn>
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
            @click="$emit('close')"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
  export default {
    props: {
        dialogState: {
            type: Boolean,
            required: true
        },
        order: {
            type: Object,
            required: true,
        }
    },
    data: () => ({
        dialog: false,
        deliverMen: [],
        deliveryMan : null,
        date_filter: (new Date()).toISOString().split('T')[0],
        time_filter: (new Date()).getHours()+ ':' + (new Date()).getMinutes(), 
        date_pick: false,
        time_pick: false,

    }),
    mounted(){
        this.initialize()
    },
    methods : {
        initialize(){
            this.$admin.get('/delivery-man/all').then(({data}) => {
                this.deliverMen = data
            })
        },
        updateOrderStatus(status){
            this.$admin.post('/order-status/'+this.order.id,{status:status}).then(({data}) => {
                data
                this.$emit('close')
            })
        },
        setDateAndTimeToDeliver(){
            this.$admin.post('/order-set-delivery-time-date/'+this.order.id,
            {
                time_filter:this.time_filter,
                date_filter:this.date_filter
            }).then(({data}) => {
                data
                this.$emit('close')
            })
        },
        setDeliveryMan(){
            this.$admin.post('/order-set-delivery-man/'+this.order.id,{delivery_man:this.deliveryMan}).then(({data}) => {
                data
                this.$emit('close')
            })
        }
       

    },

    computed : {
        orderDialog(){
            return this.dialogState
        }
    }
    
  }
</script>
<style lang="scss" scoped>
.on-the-way{
    background-color:rgb(233, 135, 151)!important;
}
.assigned-to-driver{
    background-color: rgb(216, 166, 72)!important;
}
.pending{
    background-color: rgb(192, 192, 56)!important;
}
.delivered{
    background-color: rgb(51, 115, 130)!important;
}
.accepted{
    background-color: rgb(64, 187, 64)!important;
}
.denied{
    background-color: rgb(194, 66, 66)!important;
}
.status-box{
    border-radius: 5%;
}
</style>
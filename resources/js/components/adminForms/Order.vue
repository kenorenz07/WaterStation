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
                            @click="acceptOrder"
                        >
                            Accept
                        </v-btn>
                        <v-btn
                            block
                            class="denied text-white mt-2"
                            @click="deniedOrder"
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
                    </div>
                    <div v-else-if="order.status == 'assigned-to-driver'">
                        <label for=""> get </label>
                        <v-menu
                            ref="time_picker"
                            v-model="time_picker"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            :return-value.sync="time"
                            transition="scale-transition"
                            offset-y
                            max-width="290px"
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="time"
                                label="Picker in menu"
                                prepend-icon="mdi-clock-time-four-outline"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                            </template>
                            <v-time-picker
                            v-if="time_picker"
                            v-model="time"
                            full-width
                            @click:minute="$refs.time_picker.save(time)"
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
                    <div v-else-if="order.status == 'on-the-way'">
                        C
                    </div>
                    <div v-else>
                        Not A/B/C
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

    }),
    mounted(){
        this.initialize()
    },
    methods : {
        initialize(){
            this.$admin.get('/delivery-man/all').then(({data}) => {
                this.deliverMen = data
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
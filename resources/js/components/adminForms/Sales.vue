<template>
  <v-row justify="center">
    <v-dialog
      v-model="saleDialog"
      persistent
      max-width="00px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">Sale details</span>
        </v-card-title>
         <v-card-text>
            <v-container>

                <v-row class="mt-1">
                   
                    <v-col cols="9">
                        <v-simple-table height="440" >
                            <template v-slot:default>
                                <thead>
                                    <tr>
                                        <th class="text-left">
                                            Name
                                        </th>
                                        <th class="text-left">
                                            Description
                                        </th>
                                            <th class="text-left">
                                            Product Price
                                        </th>
                                        <th class="text-left">
                                            For refill
                                        </th>
                                        <th class="text-left">
                                            Quantity
                                        </th>
                                        <th class="text-left">
                                            Total Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="item in order.orders"
                                        :key="item.id"
                                    >
                                        <td>
                                            <v-avatar>
                                                <img
                                                    :src="item.product.image ? '/storage/'+ item.product.image : 'https://upload.wikimedia.org/wikipedia/commons/7/71/Nothing_whitespace_blank.png'"
                                                    :alt="item.product.name"
                                                >
                                            </v-avatar>
                                            {{ item.product.name }}
                                        </td>
                                        <td>{{ item.product.description }}</td>
                                        <td>₱ {{ item.product.price }}</td>
                                        <td>{{ item.product.is_refill ? "Yes" : "Container for sale" }}</td>
                                        <td>{{ item.quantity }}</td>
                                        <td>₱ {{ item.total_price }}</td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
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
    }),
    mounted(){
    },
    methods : {
    },
    computed : {
        saleDialog(){
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
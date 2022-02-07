<template>
  <v-row justify="center">
    <v-dialog
      v-model="confimDialog"
      persistent
      max-width="500px"
    >
    
      <v-card>
        <v-card-title>
          Are you sure you want to continue this action? 
        </v-card-title>
        <v-card-actions>
            <v-btn
                color="blue darken-1"
                text
                @click="$emit('confirm')"
            >
                Yes
            </v-btn>
          <v-spacer></v-spacer>
            <v-btn
                color="blue darken-1"
                text
                @click="$emit('close')"
            >
                Cancel
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
    },
    data: () => ({
    }),
    mounted(){
    },
    methods : {
    },
    computed : {
        confimDialog(){
            return this.dialogState
        }
    }
    
  }
</script>
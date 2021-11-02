<template>
  <v-row justify="center">
    <v-dialog
      v-model="announceDialog"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">Announcement</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
                <v-col      
                    cols="12"
                    sm="12"
                    md="12"
                >
                    <v-textarea
                        v-model="announcement.content"
                        solo
                        label="Type content here"
                    ></v-textarea>
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
          <v-btn
            color="blue darken-1"
            text
            @click="$emit('save')"
          >
            Save
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
        announcement: {
            type: Object,
            required: true,
            default: {
                id:null,
                content:"",
            }
        }
    },
    data: () => ({
    }),
    methods : {
    },
    computed : {
        announceDialog(){
            return this.dialogState
        }
    }
    
  }
</script>
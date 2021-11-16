<template>
  <v-row justify="center">
    <v-dialog
      v-model="adminDialog"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">Edit admin</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
                <v-col      
                    cols="12"
                    sm="12"
                    md="12"
                >
                    <v-row>
                        <v-col      
                            cols="6"
                            sm="6"
                            md="6"
                        >
                            <v-text-field
                                label="Username*"
                                required
                                v-model="admin.username"
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="6"
                            sm="6"
                            md="6"
                        >
                            <v-text-field
                                label="Password*"
                                required
                                v-model="admin.password"
                                :type="show_pass ? 'text' : 'password'"
                                :append-icon="show_pass ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="show_pass = !show_pass"
                            ></v-text-field>
                        </v-col>
                        
                    </v-row>
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
            @click="save"
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
    },
    data: () => ({
        show_pass : false,
        dialog: false,
        admin : {
            username: '',
            password: '',
        }
    }),
    mounted (){
        console.log('heheheheh')
        this.initialize()
    },
    methods : {
        initialize(){
            this.$admin.get('details').then(({data}) => {
                this.admin.username = data.username
            })
        },
        save(){
            this.$admin.post('update',this.admin).then(({data}) => {
                this.$emit('close')
            })
        }
    },
    computed : {
        adminDialog(){
            return this.dialogState
        }
    }
    
  }
</script>
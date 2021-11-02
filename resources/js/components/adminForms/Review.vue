<template>
  <v-row justify="center">
    <v-dialog
      v-model="reviewDialog"
      persistent
      max-width="900px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">Review by {{review.user.name}}</span>
        </v-card-title>
         <v-card-text>
            <v-container>
                <v-card
                    class="mx-auto"
                    outlined
                >
                    <v-card-text>
                        <div class="text--primary">
                            {{review.review}}
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            class="mr-2"
                            color="light-blue"
                            @click="reply_state = true"
                        >
                            Reply
                        </v-btn>
                    </v-card-actions>
                </v-card>
                <v-card
                    v-if="reply_state"
                    class="ml-10"
                    outlined
                >
                    <v-card-text>
                        <v-textarea
                            v-model="reply_text"
                            solo
                            rows="1"
                            label="Put reply here"
                        ></v-textarea>
                        <v-btn
                            text
                            color="red"
                            @click="cancel"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            text
                            color="light-blue"
                            @click="reply_id ? updateReply() : replySubmit()"
                        >
                            Sumbit
                        </v-btn>
                    </v-card-text>
                </v-card>
                <v-card
                    class="ml-10"
                    outlined
                    v-for="reply in review.replies"
                    :key="reply.id"
                >
                    <v-card-text>
                        <div class="text--primary">
                            {{reply.reply}}
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            class="mr-2"
                            color="light-blue"
                            @click="editReply(reply)"
                        >
                            Edit
                        </v-btn>
                        <v-btn
                            class="mr-2"
                            color="red"
                            @click="deleteReply(reply)"
                        >
                            delete
                        </v-btn>
                    </v-card-actions>
                </v-card>
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
        review: {
            type: Object,
            required: true,
        }
    },
    data: () => ({
        reply_state: false,
        reply_text : '',
        reply_id: null,
    }),
    mounted(){
    },
    methods : {
        cancel () {
            this.reply_id  = null
            this.reply_text= ''
            this.reply_state = false
        },
        replySubmit(){
            this.$admin.post('/review/add-reply/'+this.review.id, {reply: this.reply_text}).then(({data}) => {
                this.$emit('reload')
                this.cancel()
            });
        },
        editReply(reply){
            this.reply_id  = reply.id
            this.reply_text = reply.reply
            this.reply_state = true
        },
        updateReply(){
            this.$admin.put('/review/update-reply/'+this.reply_id, {reply: this.reply_text}).then(({data}) => {
                this.cancel()
                this.$emit('reload')
            });
        },
        deleteReply(reply){
            this.$admin.delete('/review/delete-reply/'+reply.id).then(({data}) => {
                this.cancel()
                this.$emit('reload')
            });
        }
    },
    computed : {
        reviewDialog(){
            return this.dialogState
        }
    }
    
  }
</script>
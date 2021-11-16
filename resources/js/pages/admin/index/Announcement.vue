<template>
    <div>
        <v-card
            class="mx-auto px-5 py-5"
            outlined
        >
            <v-card-title>
                Announcements
                <v-spacer></v-spacer>
                    <v-icon
                    large
                    @click="announcement_dialog =true"
                    >
                    mdi-plus
                    </v-icon>
            </v-card-title>
            <v-container>
                <v-simple-table >
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    Announcement
                                </th>
                                <th class="text-left">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="announcement in announcements"
                                :key="announcement.id"
                            >
                                <td>{{ announcement.content }}</td>   
                                <td>
                                    <v-icon
                                        class="mr-2"
                                        @click="editAnnouncement(announcement)"
                                    >
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon
                                        class="mr-2"
                                        @click="confirmDialog = true,deletion_id = announcement.id"
                                    >
                                        mdi-delete
                                    </v-icon>
                                </td>                        
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-container>
        </v-card>
        <AnnouncementForm :announcement="announcement" :dialogState="announcement_dialog" @close="announcement_dialog = false" @save="saveAnnouncement"/>
        <Confirmation :dialogState="confirmDialog" @close="confirmDialog = false" @confirm="deleteAnnouncement"/>

    </div>
</template>
<script>
import Confirmation from '../../../components/Confirm.vue'
import AnnouncementForm from '../../../components/adminForms/Announcement.vue'

export default {
    data : () => ({
        announcements: [],
        announcement: {},
        announcement_dialog: false,
        confirmDialog: false,
        deletion_id : null,
    }),
    components : {
        AnnouncementForm,
        Confirmation
    },
    mounted () {
        this.initialize()
    },
    methods : {
        initialize(){
            this.$admin.get('/announcement/all').then(({data}) => {
                this.announcements = data;
            });
        },
        editAnnouncement(announcement) {
            this.announcement = announcement
            this.announcement_dialog = true
        },
        saveAnnouncement(){
            if(this.announcement.id){
                this.$admin.put('/announcement/update/'+this.announcement.id, this.announcement).then(({data}) => {
                    this.initialize()
                });
            }
            else{
                this.$admin.post('/announcement/create', this.announcement).then(({data}) => {
                    this.initialize()
                });
            }
            this.announcement_dialog = false
        },
        deleteAnnouncement(){
            this.confirmDialog = false
            this.$admin.delete('/announcement/delete/'+ this.deletion_id ).then(({data}) => {
                this.initialize()
                this.deletion_id = null
            });
        },
    }
}
</script>
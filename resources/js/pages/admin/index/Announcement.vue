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
                                        @click="deleteAnnouncement(announcement)"
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

    </div>
</template>
<script>
import AnnouncementForm from '../../../components/adminForms/Announcement.vue'

export default {
    data : () => ({
        announcements: [],
        announcement: {},
        announcement_dialog: false,
    }),
    components : {
        AnnouncementForm
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
        deleteAnnouncement(announcement){
            console.log('gsgsgs')
            this.$admin.delete('/announcement/delete/'+ announcement.id).then(({data}) => {
                this.initialize()
            });
        },
    }
}
</script>
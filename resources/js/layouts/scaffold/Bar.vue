<template>
    <v-app-bar app color="light-blue">
      <v-app-bar-nav-icon @click="$emit('drawerChange')"></v-app-bar-nav-icon>

      <v-toolbar-title>ALKSURE WATER REFILLING STATION</v-toolbar-title>
      <v-spacer></v-spacer>
        <AdminForm :dialogState="admin_dialog" @close="admin_dialog = false" />
      <v-spacer></v-spacer>
        <v-btn
          fab
          dark
          small
          color="light-blue"
          @click="admin_dialog = true"
        >
          <v-icon >
            mdi-account-circle-outline
          </v-icon>
        </v-btn>

    </v-app-bar>
</template>
<style lang="scss" scoped>

</style>
<script>
import AdminForm from '../../components/adminForms/Admin.vue'

 export default {
    components : {
        AdminForm,
    },
    data: () => ({
      admin_dialog : false
    }),
  }
</script>
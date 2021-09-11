<template>
  <v-app id="inspire">
    
    <!-- <v-navigation-drawer
      
    >
    </v-navigation-drawer> -->
    <app-drawer :is_open="drawer"></app-drawer>
    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Application</v-toolbar-title>
    </v-app-bar>

   
  </v-app>
</template>

<script>
  import AppDrawer from './Drawer.vue'
  import AppContent from './Content.vue'
  export default {
    components : {
      AppDrawer,
      AppContent,
    },
    data: () => ({ 
      drawer: true 
    }),
    mounted(){
    }
  
  }
</script>
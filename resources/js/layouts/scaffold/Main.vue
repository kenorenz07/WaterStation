<template>
  <v-app id="inspire">
    
    <!-- <v-navigation-drawer
      
    >
    </v-navigation-drawer> -->
    <app-drawer :is_open="drawer"></app-drawer>
    <app-bar @drawerChange="drawer = !drawer"> </app-bar>
    <app-content> </app-content>

   
  </v-app>
</template>

<script>
  import AppDrawer from './Drawer.vue'
  import AppBar from './Bar.vue'
  import AppContent from './Content.vue'
  export default {
    components : {
      AppDrawer,
      AppContent,
      AppBar,
    },
    data: () => ({ 
      drawer: true 
    }),
    mounted(){
    }
  
  }
</script>
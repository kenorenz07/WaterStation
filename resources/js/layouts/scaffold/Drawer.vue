<template>
    <v-navigation-drawer persistent 
        v-model="drawer"
        app
    >
        <template v-slot:prepend> 
          <v-list-item >
              <v-list-item-avatar>
                  <v-img src="/images/icon.png"></v-img>
              </v-list-item-avatar>

              <v-list-item-title class="text-subtitle-1">
                Welcome {{admin_detials.username}}!
              </v-list-item-title>

          </v-list-item>
        <v-divider></v-divider>
      </template>


      <v-list >
        <v-list-item
          rounded
          v-for="item in items"
          :key="item.title"
          link
          :to="item.route"
          active-class="light-blue white--text text--lighten-1"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <template v-slot:append>
        <div class="pa-2">
          <v-btn block @click="confirmDialog = true">
            Log out
          </v-btn>
        </div>
      </template>
      <Confirmation :dialogState="confirmDialog" @close="confirmDialog = false" @confirm="logoutAdmin"/>

    </v-navigation-drawer>
</template>
<script>
import Confirmation from '../../components/Confirm.vue'
  export default {
    props : {
        is_open: Boolean
    },
    components : {
      Confirmation
    },
    data () {
      return {
        confirmDialog: false,
        items: [
          { title: 'Dashboard', icon: 'mdi-view-dashboard', route: '/dashboard' },
          { title: 'Announcements', icon: 'mdi-bullhorn', route: '/announcements' },
          { title: 'Customers', icon: 'mdi-account-group', route: '/customers' },
          { title: 'Delivery Men', icon: 'mdi-car', route: '/delivery-men' },
          { title: 'Products', icon: 'mdi-water', route: '/products' },
          { title: 'Delivery Orders', icon: 'mdi-cart', route: '/orders' },
          { title: 'Reviews', icon: 'mdi-message-draw', route: '/reviews' },
          { title: 'Delivery Sales', icon: 'mdi-point-of-sale', route: '/sales' },
        ],
        admin_detials: {},
        route_open: ''
      }
    },
    computed : {
        drawer: {
            get: function () {
                return this.is_open
            },
            set: function (newValue) {
                
            }
        },
    },
    mounted () {
      this.$admin.get('/details').then(({data}) => {
          this.admin_detials = data
      })
    },
    methods: {
      logoutAdmin(){
        this.$admin.post('/logout').then(({data}) => {
          localStorage.removeItem("token")
          this.$router.push('/login')
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
    .v-divider {
        margin-top: 7px!important;
    }
</style>
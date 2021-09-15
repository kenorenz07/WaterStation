<template>
    <v-navigation-drawer persistent 
        v-model="drawer"
        app
    >
        <template v-slot:prepend> 
          <v-list-item >
              <v-list-item-avatar>
                  <v-img src="https://cdn-icons-png.flaticon.com/512/599/599508.png"></v-img>
              </v-list-item-avatar>

              <v-list-item-title class="text-subtitle-1">
                Welcome {{admin_detials.username}} !
              </v-list-item-title>

          </v-list-item>
        <v-divider></v-divider>
      </template>


      <v-list 
      >
        <v-list-item
          rounded
          v-for="item in items"
          :key="item.title"
          link
          @click="$router.push(item.route)"
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
          <v-btn block>
            Logout
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>
</template>
<script>
  export default {
    props : {
        is_open: Boolean
    },
    data () {
      return {
        items: [
          { title: 'Dashboard', icon: 'mdi-view-dashboard', route: '/dashboard' },
          { title: 'Products', icon: 'mdi-cash-100', route: '/products' },
          { title: 'Orders', icon: 'mdi-cart', route: '/customers' },
          { title: 'Customers', icon: 'mdi-account-group', route: '/delivery-men' },
          { title: 'Delivery', icon: 'mdi-car', route: '/orders' },
          { title: 'Sales', icon: 'mdi-mdi-point-of-sale', route: '/sales' },
        ],
        admin_detials: {}
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
    }
  }
</script>

<style lang="scss" scoped>
    .v-divider {
        margin-top: 7px!important;
    }
</style>
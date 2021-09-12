<template>
    <v-navigation-drawer persistent 
        v-model="drawer"
        app
    >
            
        <v-list-item >
            <v-list-item-avatar>
                <v-img src="https://cdn-icons-png.flaticon.com/512/599/599508.png"></v-img>
            </v-list-item-avatar>

            <v-list-item-title >Welcome {{admin_detials.username}} !</v-list-item-title>

        </v-list-item>

      <v-divider></v-divider>

      <v-list rounded
      >
        <v-list-item
          v-for="item in items"
          :key="item.title"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
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
          { title: 'Dashboard', icon: 'mdi-view-dashboard' },
          { title: 'Products', icon: 'mdi-cash-100' },
          { title: 'Orders', icon: 'mdi-cart' },
          { title: 'Customers', icon: 'mdi-account-group' },
          { title: 'Delivery', icon: 'mdi-car' },
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
      this.$admin.get('/admin/v1/details').then(({data}) => {
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
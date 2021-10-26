<template>
  <CSidebar 
    fixed 
    :minimize="minimize"
    :show="show"
    @update:show="(value) => $store.commit('set', ['sidebarShow', value])"
  >
    <CSidebarBrand class="d-md-down-none" to="/">
      <CIcon 
        class="d-block" 
        name="logo" 
        size="custom-size" 
        :height="35" 
        :viewBox="`0 0 ${minimize ? 110 : 556} 134`"
      />
    </CSidebarBrand>
    <CRenderFunction flat :content-to-render="nav"/>
    <CSidebarMinimizer
      class="d-md-down-none"
      @click.native="$store.commit('set', ['sidebarMinimize', !minimize])"
    />
  </CSidebar>
</template>

<script>
import axios from 'axios'
export default {
  name: 'TheSidebar',
  data () {
    return {
      //minimize: false,
      nav: [],
      //show: true,
      buffor: [],
    }
  },
  computed: {
    show () {
      return this.$store.state.sidebarShow 
    },
    minimize () {
      return this.$store.state.sidebarMinimize 
    }
  },
  methods: {
    dropdown(data){
      let result = {
            _name: 'CSidebarNavDropdown',
            name: data['name'],
            route: data['href'],
            icon: data['icon'],
            _children: [],
      }
      for(let i=0; i<data['elements'].length; i++){
        if(data['elements'][i]['slug'] == 'dropdown'){
          result._children.push( this.dropdown(data['elements'][i]) );
        }else{
          result._children.push(
            {
                   _name:  'CSidebarNavItem',
                   name:   data['elements'][i]['name'],
                   to:     data['elements'][i]['href'],
                   icon:   data['elements'][i]['icon']
            } 
          );
        }
      }
      return result;
    },
    rebuildData(data){
      this.buffor = [{    
        _name: 'CSidebarNav',
        _children:  [
          {
            _name: 'CSidebarNavItem',
            name: 'Empomer',
            to: '/dashboard',
            icon: 'cil-speedometer',
            badge: {
              color: 'primary',
              text: 'NEW'
            }
          },      
          {
            _name: 'CSidebarNavItem',
            name: 'Categorias',
            to: '/category/list',
            icon: 'cil-list',       
          },
          {
            _name: 'CSidebarNavItem',
            name: 'Ofrendas',
            to: '/gift/list',
            icon: 'cil-list',       
          },
          {
            _name: 'CSidebarNavItem',
            name: 'Post',
            to: '/post/list',
            icon: 'cil-list',       
          },
          {
            _name: 'CSidebarNavItem',
            name: 'Customer',
            to: '/customer/list',
            icon: 'cil-list',       
          }        
        ]
      }];
      return this.buffor;
    }
  },
  mounted () {
    this.$root.$on('toggle-sidebar', () => {
      const sidebarOpened = this.show === true || this.show === 'responsive'
      this.show = sidebarOpened ? false : 'responsive'
    })
    this.$root.$on('toggle-sidebar-mobile', () => {
      const sidebarClosed = this.show === 'responsive' || this.show === false
      this.show = sidebarClosed ? true : 'responsive'
    })
    let self = this;

    console.log(this.$apiAdress);

    axios.get( this.$apiAdress + '/api/menu?token=' + localStorage.getItem("api_token") )
    .then(function (response) {
      console.log(response.data);
      self.nav = self.rebuildData(response.data);
    }).catch(function (error) {
      console.log(error);
      self.$router.push({ path: '/login' });
    });
  }
}
</script>

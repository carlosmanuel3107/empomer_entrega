<template>
  <div class="c-app row body-wrapper" data-spy="scroll" data-target=".privacy-nav">       
    <TheHeader />         
    <main class="col-12">            
        <transition name="fade" mode="out-in">
          <router-view :key="$route.path"></router-view>
        </transition>              
    </main>    
    <TheFooter class="col-12"/>        
    
    <div class="scroll-top-to">
        <i class="ti-angle-up"></i>
    </div>    
  </div>  
</template>

<script>
import "@/assets/index/css/style.css";
import TheHeader from './TheHeader'
import TheFooter from './TheFooter'

export default {
  name: 'TheContainer',
  components: {
    TheHeader,
    TheFooter
  }
}
</script>

<style scoped>
  .red{        
      color:red;
  }

</style>
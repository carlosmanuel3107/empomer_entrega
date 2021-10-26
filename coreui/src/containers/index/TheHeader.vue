<template>
    <nav class="navbar main-nav navbar-expand-lg px-2 px-sm-0 py-2 py-lg-0">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="@/assets/index/images/empomer_01.jpeg" alt="logo"><img src="@/assets/index/images/empomer_esp.png" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="ti-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">                
                <li class="nav-item @@about">                    
                    <router-link class="nav-link" v-bind:to="'/index'">Home</router-link>
                </li>                
                <li class="nav-item @@about">                    
                    <router-link class="nav-link" v-bind:to="'/index/publications'">Noticias</router-link>
                </li>
                <li class="nav-item @@contact">
                    <router-link class="nav-link" v-bind:to="'/index/contact'">Contacto</router-link>
                </li>                            
            </ul>
            </div>
             <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto"> 
                    <li>    
                        <router-link class="dropdown-item" v-bind:to="'/login'">Iniciar sesion</router-link>
                    </li>
                    <li>
                        <router-link class="dropdown-item" v-bind:to="'/register'">Registrase</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>

export default {
  name: 'TheHeader',
  components: {

  }
}
</script>

<style scoped>
  .red{        
      color:red;
  }

</style>
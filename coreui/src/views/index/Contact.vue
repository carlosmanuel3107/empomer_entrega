<template>
    <div>
        <!--================================
        =            Page Title            =
        =================================-->

        <section class="section page-title">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 m-auto">
                        <!-- Page Title -->
                        <h1>Contactanos</h1>
                        <!-- Page Description -->
                        <p>Somos una empresa totalmente comprometida con el municipio de Mercaderes Cauca, somos los encargados de mantener con agua potable la cabecera municipal.</p>
                    </div>
                </div>
            </div>
        </section>

        <!--====  End of Page Title  ====-->


        <!--=====================================
        =            Address and Map            =
        ======================================-->
        <section class="address">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 align-self-center">
                        <div class="block">
                            <div class="address-block text-center mb-5">
                                <div class="icon">
                                    <i class="ti-mobile"></i>
                                </div>
                                <div class="details">
                                    <h3>Carlos Silva</h3>
                                    <h2>Gerente</h2>
                                    <h2>(88) 016 725 0455 (UK)</h2>
                                </div>
                            </div>
                            <div class="address-block text-center">
                                <div class="icon">
                                    <i class="ti-map-alt"></i>
                                </div>
                                <div class="details">
                                    <h3>Carlos Silva</h3>
                                    <h2>Administrativo</h2>
                                    <h2>(88) 016 725 0455 (UK)</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 mt-5 mt-lg-0">
                        <div class="google-map">
                            <!-- Google Map -->                  
                            <h1 style="text-align: center;">Empomer</h1>
                            <GoogleMap :latitude= 1.798803 :longitude= -77.165367 :title="'Mercaderes'"/>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--====  End of Address and Map  ====-->
        <section class="contact-form section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="mb-5 text-center">Deja tu mensaje</h2>
                    </div>
                    <div class="col-12">
                        <form action="">
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-6 mb-2">
                                    <input class="form-control main" type="text" placeholder="Nombre" required>
                                </div>
                                <!-- Email -->
                                <div class="col-md-6 mb-2">
                                    <input class="form-control main" type="email" placeholder="Email" required>
                                </div>
                                <!-- subject -->
                                <div class="col-md-12 mb-2">
                                    <input class="form-control main" type="text" placeholder="Asunto" required>
                                </div>
                                <!-- Message -->
                                <div class="col-md-12 mb-2">
                                    <textarea class="form-control main" name="message" rows="10" placeholder="Descripcion"></textarea>
                                </div>
                                <!-- Submit Button -->
                                <div class="col-12 text-right">
                                    <button class="btn btn-main-md">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import GoogleMap from "../maps/GoogleMap";

export default {
  name: 'Contact',
  components: {
      GoogleMap
  }
}
</script>

<style scoped>
  .red{        
      color:red;
  }

</style>
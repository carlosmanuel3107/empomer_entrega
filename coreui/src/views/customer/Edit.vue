<template>
  <div>
    <CCard>      
      <CCardHeader class ="">        
        <div class="row">
          <div class="col-10">
            <h1><CIcon name="cil-pencil"/> <small>Editar prueba de penetración </small></h1>            
          </div>
          <div class="col">
            <button id="btnList" v-on:click="list_customer()" class="btn btn-primary btn text-right"><CIcon name="cil-list"/></button>                                            
          </div>            
        </div>                  
      </CCardHeader>
      

      <CCardBody>           
          <div>          
              <!--<div style="height: 30px;"></div>-->
              <div class="container">
                  <div class="row">
                      <div class="col-lg-12">
                      <div class="card shadow-lg p-3 mb-5 bg-white border-0">
                          <div class="card-header bg-dark text-white">Formulario de edición</div>                                
                              <div class="card-body">
                                  <form v-on:submit.prevent="send_form_edition">
                                      <section v-if="errored">
                                      <div v-for="(err,index) in errors" v-bind:key="index">
                                          <div class="alert alert-danger" role="alert">
                                              {{err.message}}
                                          </div>    
                                      </div>
                                  </section>  
                                                                                        

                                   <div class="form-row">                                    
                                            <div class="col-md-6 mb-3">                    
                                                <label for="first_name" >Nombre:<span class="red">*</span></label>
                                                <input  type="text" class="form-control" v-model="customer_o.first_name" id="first_name" name=first_name  placeholder="Nombre" required >
                                            </div>

                                            <div class="col-md-6 mb-3">                    
                                                <label for="last_name" >Apellido:<span class="red">*</span></label>
                                                <input  type="text" class="form-control" v-model="customer_o.last_name" id="last_name" name=last_name  placeholder="Apellido" required >
                                            </div>                                                                                                                                  
                                        </div>
                                        
                                        <div class="form-row">                                            
                                            <div class="col mb-6">
                                                <label for="state">Estracto:<span class="red">*</span></label>                                                                                     
                                                <select class="custom-select" id="extract" v-model="customer_o.extract" name="extract" required>                       
                                                    <option :value="1">1</option>           
                                                    <option :value="2">2</option>           
                                                    <option :value="3">3</option>           
                                                    <option :value="4">4</option>           
                                                    <option :value="5">5</option>           
                                                </select>
                                            </div>                                                                                                                                                                
                                        </div>

                                        <div class="form-row">                                                                                                                                    
                                            <div class="col mb-3">
                                                <label for="direction">Dirección:<span class="red">*</span></label>
                                                <input placeholder="Dirección"  type="text" class="form-control" v-model="customer_o.direction" id="direction" name="direction" required>
                                            </div>                                        
                                        </div>

                                        <div class="form-row">                                                                                                                                    
                                            <div class="col mb-3">
                                                <label for="telephone">Telefono:<span class="red">*</span></label>
                                                <input placeholder="Telefono"  type="text" class="form-control" v-model="customer_o.telephone" id="telephone" name="telephone" required>
                                            </div>                                        
                                        </div>                                    
                                    
                                        <div class="form-row">                       
                                            <button class="btn btn-primary mr-3 mb-3" type="submit" name="submit">Guardar</button>
                                            <button class="btn btn-success mb-3" type="reset" name="reset">Limpiar</button>
                                        </div>          
                                  </form>
                              </div>   
                          </div>   
                      </div>   
                  </div>
              </div>       
          </div>                          

      </CCardBody>
    </CCard>            
  </div>
    
</template>>

<script>
  import axios from "axios";
  import Vuex from 'vuex';
  export default {
    name: 'Customer_edit',   
    data () {
      return {
          errored: false,
          loading: true,
          errors: [],
          categories: null,                  
          customer_o:{
            first_name: '',
            last_name: '',
            extract: 1,
            direction: '',
            telephone: 0                         
        },
        category_name : ''      
      }
    }, 
    filters: {      
    },
    computed:{
      ...Vuex.mapState('StoreCustomer',['customer','success'])    
    },
    methods: {
       ...Vuex.mapActions('StoreCustomer',['add_message_success']),   
      send_form_edition(e){
          e.preventDefault();          
          axios.put(this.$server+'/api/v1/customers/update/'+this.customer_o.id, this.customer_o)
          .then(response => {
              console.log(response)            
              this.add_message_success({'message':'La prueba de penetración: '+this.customer_o.first_name+' ha sido actualizada correctamente.'});                  
              this.$router.push('/customer/list');
          })
          .catch(error => {              
              console.log(error); 
              this.succed=false;             
              this.errored = true;
              this.errors = [];
              this.errors.push({'message':'No se ha podido actualizar la prueba de penetración, revise que el id owasd o el nombre no este repetidos.'})            
        })
        .finally(() => this.loading = false);                              
      },
      list_customer(){
          this.$router.push('/customer/list');
      }
    }, 
    mounted() {
        console.log(this.customer_o);
      this.customer_o = this.customer;    
    }
  };  
</script>

<style scoped>
    .red{        
        color:red;
    }
    
</style>
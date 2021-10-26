<template>
    <div>
    <CCard>      
      <CCardHeader class ="">        
        <div class="row">
          <div class="col-10">
            <h1><CIcon name="cil-plus"/> <small>Registrar cliente </small></h1>       
          </div>
          <div class="col">
            <button id="btnList" v-on:click="list_customer()" class="btn btn-primary btn text-right"><CIcon name="cil-list"/></button>                                            
          </div>            
        </div>                       
      </CCardHeader> 

        <CCardBody>           
            <div>                
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="card shadow-lg p-3 mb-5 bg-white border-0">
                            <div class="card-header bg-dark text-white">Formulario de registro</div>                                
                                <div class="card-body">
                                    <form v-on:submit.prevent="send_form">
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
                                                <input  type="text" class="form-control" v-model="customer.first_name" id="first_name" name=first_name  placeholder="Nombre" required >
                                            </div>

                                            <div class="col-md-6 mb-3">                    
                                                <label for="last_name" >Apellido:<span class="red">*</span></label>
                                                <input  type="text" class="form-control" v-model="customer.last_name" id="last_name" name=last_name  placeholder="Apellido" required >
                                            </div>                                                                                                                                  
                                        </div>
                                        
                                        <div class="form-row">                                            
                                            <div class="col mb-6">
                                                <label for="state">Estracto:<span class="red">*</span></label>                                                                                     
                                                <select class="custom-select" id="extract" v-model="customer.extract" name="extract" required>                       
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
                                                <input placeholder="Dirección"  type="text" class="form-control" v-model="customer.direction" id="direction" name="direction" required>
                                            </div>                                        
                                        </div>

                                        <div class="form-row">                                                                                                                                    
                                            <div class="col mb-3">
                                                <label for="telephone">Telefono:<span class="red">*</span></label>
                                                <input placeholder="Telefono"  type="text" class="form-control" v-model="customer.telephone" id="telephone" name="telephone" required>
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
    name: 'Customer_create',   
    data() {
        return{            
            errored: false,
            loading: true,
            errors: [],
            categories: null,
            customer:{                                    
                first_name: '',
                last_name: '',
                extract: 1,
                direction: '',
                telephone: 0,                                
            },           
        }
    },    
    methods:{       
        ...Vuex.mapActions('StoreCustomer',['add_message_success']),    
        send_form(e){
            e.preventDefault();                      
            axios.post(this.$server+'/api/v1/customers/create/', this.customer)
            .then(response => {
                console.log(response);  
                this.add_message_success({'message':'La cliente: '+this.customer.first_name+' ha sido registrada correctamente.'});                  
                this.$router.push('/customer/list');
            })
            .catch(error => {        
                console.log(error);                      
                this.errored = true;
                this.errors = [];
                this.errors.push({'message':'No se ha podido realizar el registro del cliente'})            
          })
          .finally(() => this.loading = false);
                                       
        },
        list_customer(){
            this.$router.push('/customer/list');
        } 
    }   
  };  
</script>

<style scoped>
    .red{        
        color:red;
    }
    
</style>
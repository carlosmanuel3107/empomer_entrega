<template>
  <div>     
    <CCard>      
      <CCardHeader>
        <h1><CIcon name="cil-list"/> <small>Lista de ofrendas</small></h1>                            
      </CCardHeader>
      
      <CCardBody>        
          <div class="container-fluid" v-if="!create_gift">
            <div class="row">
                <div class="col-10">
                    <div class="demo">
                      <form class="form-search">
                        <div class="input-group">                        
                            <input type="text" placeholder="Buscar categoria" class="form-control col-lg-9" v-model="name">                           
                            <div class="input-group-append">
                              <button  type="button" class="btn btn-primary"><CIcon name="cil-search"/></button>
                            </div>                                                                              
                        </div>
                      </form>
                    </div>                    
                </div>

                <div class="col" >                    
                    <button id="btnAdd" v-on:click="create_gift_()" class="btn btn-success btn text-right"><CIcon name="cil-plus"/></button>                    
                </div>
            </div>            
        </div>    

        <div class="row" style="margin-top: 10px">
          <div class="col-12">
              <table id="grid"></table>
          </div>
        </div>                
        
        <section v-if="errored">
          <div v-for="(err,index) in errors" v-bind:key="index">
            <div class="alert alert-danger" role="alert">
                {{err.message}}
            </div>    
          </div>
        </section>                 

        <section v-else>              
           <section v-if="succed">
            <div v-for="(succ,index) in success" v-bind:key="index">
              <div class="alert alert-success" role="alert">
                  {{succ.message}}
              </div>    
            </div>
            </section> 
        </section>  

        <div v-if="create_gift">
              <div>          
                <!--<div style="height: 30px;"></div>-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="card shadow-lg p-3 mb-5 bg-white border-0">
                            <div class="card-header bg-dark text-white">Formulario de registro</div>                                  
                                <div class="card-body">
                                    <form ref="f_" v-on:submit.prevent="send_form">                                         
                                        
                                        <div class="form-row">                                    
                                            <div class="col-md-6 mb-3">                    
                                                <label for="name" >Nombre:<span class="red">*</span></label>
                                                <input  type="text" class="form-control" v-model="gift_form.name" id="name" name=name  placeholder="Nombre">
                                            </div>
                                            <div class="col-md-6 mb-3">                    
                                                <label for="price" >Precio:<span class="red">*</span></label>
                                                <input  type="text" class="form-control" v-model="gift_form.price" id="price" name=price  placeholder="Precio">
                                            </div>                                                                                                                                                                                                           
                                        </div>             

                                        <div class="mb-3">
                                            <label for="category">Categoria:<span class="red">*</span></label>                                     
                                            
                                            <select class="custom-select" id="category_id" v-model="gift_form.category_id" name="category_id" required>
                                                <option value="">Selecciona una categoría</option>
                                                <option selected="true" v-for="category in categories"  v-bind:key="category.id" :value="category.id">{{category.name}}</option>           
                                            </select>
                                        </div>                           
                                                          
                                        <div class="form-row">                       
                                            <button class="col-0 btn btn-primary mr-3 mb-3" type="submit" name="submit">Guardar</button>
                                            <button class="col-0 btn btn-danger mb-3" v-on:click="cancel_create()" type="reset" name="reset">Cancelar</button>                              
                                        </div>                  
                                    </form>
                                </div>   
                            </div>   
                        </div>   
                    </div>
                </div>       
            </div>                          

        </div>

        <CRow>               
            <div  class="table-responsive"></div>
              <table class="table table-striped">
                <thead class="thead-dark">
                  <tr >
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>                                        
                    <th scope="col">Opciones</th>                                     
                  </tr>
                </thead>
          
                <tbody >                  
                  <tr v-for="(gift,index) in pageOfItems" v-bind:key="gift.id">  
                    <th scope="row">{{index+1}}</th> 
                    <td>
                      <div v-if = "index_edit != index">
                        <label @dblclick = "index_edit=-1"> {{gift.name}} </label>
                      </div>
                      <input name="gift_name" 
                        v-else-if = "index_edit == index" 
                        v-model = "gift.name" 
                        
                        @keyup.enter = "index_edit=-1; save_gift(gift)">
                    </td>                                                                                                                                          
                  
                    <td>
                        <div v-if="index_edit== index">
                            <div class="btn-toolbar text-right">                                                
                                <button  v-on:click="save_gift(gift)" class="btn btn-success btn-sm mr-3"><CIcon name="cil-check-alt"/></button>                                                                    
                                <button  v-on:click="cancel_edit()" class="btn btn-danger  btn-sm"><CIcon name="cil-x"/></button>                           
                            </div>
                        </div>                 

                        <div v-else>              
                            <div class="btn-toolbar text-right">                                                
                                <button  v-on:click="edit_gift(index)" class="btn btn-primary btn-sm mr-3"><CIcon name="cil-pencil"/></button>                                                                    
                                <button  @click="darkModal = true, gift_deleted = gift" class="btn btn-danger  btn-sm"><CIcon name="cil-trash"/></button>                           
                            </div>                    
                        </div>                        
                    </td>
                  </tr>                  
                </tbody>                                
              </table>   

          </CRow>    
           <div class="card-footer row justify-content-end">
            <jw-pagination :items="search_gifts" @changePage="onChangePage" :labels="customLabels"></jw-pagination>
          </div>               
                             
         <CModal
          :show.sync="darkModal"
          :no-close-on-backdrop="true"
          :centered="true"
          title="Modal title 2"
          size="lg"
          color="dark"
            >
            Está seguro(a) de eliminar la categoría de nombre: {{gift_deleted.name}}.
          <template #header>
            <h6 class="modal-title"><CIcon name="cil-trash"/> Eliminar categoria</h6>
            <CButtonClose @click="darkModal = false" class="text-white"/>
          </template>
          <template #footer>
            <CButton @click="darkModal = false" color="danger">Cancelar</CButton>
            <CButton v-on:click="remove_gift()" color="success">Eliminar</CButton>
          </template>
        </CModal>           
      </CCardBody>
       
    </CCard>    
  </div>               
</template>>

<script>
  import axios from "axios";
  //import Vuex from 'vuex';
  const customLabels = {
    first: '<<',
    last: '>>',
    previous: '<',
    next: '>'
  };
  export default {
    name: 'Gift_list', 
    components: {   
    },  
    data () {
      return {    
        gifts : [],
        loading: false,
        errored: false,
        errors: [],
        succed: true,
        success: [],                                   
        darkModal: false,
        gift_deleted:'',         
        pageOfItems: [],
        customLabels,    
        selectedUser: null,
        index_edit: -1,        
        gift_form : {
          name : '',
          price: 0,
          category_id:''
        },
        creategift_form: false,
        count_attacks_search:0,
        name:'',
        categories:{},
        create_gift :false
        /*gifts_prueba:[
          {
            id: 1,
            gift_name: 'Categoria 1',
            state: true,    
            description: 'Categoria 1'                            
          },
          {
            id: 2,
            gift_name: 'Categoria 2',
            state: true,    
            description: 'Categoria 2'                            
          },
          {
            id: 3,
            gift_name: 'Categoria 3',
            state: true,    
            description: 'Categoria 3'                            
          },
        ]*/
      }
    }, 
    filters: {      
    },
    computed:{    
      search_gifts: function () {       
        if (this.name==''){
          return this.gifts;
        }else{                      
          return this.gifts.filter((gift) => gift.name.includes(this.name));          
        }        
      }       
    },
    methods: {
      //...Vuex.mapActions('StoreAttack',['get_attacks', 'remove_attack','attack_aux']),
      clean_form(){
        this.gift_form.name='';                
        this.gift_form.price='0';  
      },
      send_form(e){          
          e.preventDefault();      
          let form = this.gift_form;
          console.log(this.gift_form);
          axios.post(this.$server+'/api/v1/gifts/create/', form)
          .then(response => {
              console.log(response)
              this.succed=true;
              this.success = [];    
              this.success.push({'message': 'La ofrenda:'+form.name+' ha sido registrada correctamente.'});
              this.create_gift= false;
              this.clean_form();
              this.get_gifts()
          })
          .catch(error => {              
              console.log(error);                
              this.errored = true;
              this.errors = [];
              this.errors.push({'message':'No se ha podido realizar el registro, revise que la ofrenda no exista.'})            
          })
          .finally(() => this.loading = false);                           
      },    
      get_categories(){
          const path = this.$server+'/api/v1/categories/';                
          axios.get(path).then(response => {    
              console.log(response.data.data[0].categories);   
              this.categories = response.data.data[0].categories;                            
          }).catch(error => {
              console.log(error);     
              this.errored= true;
              this.errors=[];
              this.errors.push({'message':'¡Lascategorias no se pudieron cargar!!!'});                
          }).finally(() => this.loading = false);               
      },
      get_gifts(){
            const path = this.$server+'/api/v1/gifts/';                
            axios.get(path).then(response => {    
                console.log(response.data.data[0].gifts);   
                this.gifts = response.data.data[0].gifts;                            
            }).catch(error => {
                console.log(error);     
                this.errored= true;
                this.errors=[];
                this.errors.push({'message':'¡Lo sentimos los datos no estan disponibles en estos momentos, intentalo más tarde!!!'});                
            }).finally(() => this.loading = false);               
        },
      remove_gift(){        
        this.darkModal = false;
        const path = this.$server+'/api/v1/gifts/delete/'+this.gift_deleted.id;
        axios.delete(path).then(response => {                           
            console.log(response);   
            this.succed = true;
            this.success=[];
            this.success.push({'message':'¡La categoría '+this.gift_deleted.name+' ha sido eliminada!'})
            this.get_gifts();
        })
        .catch(error => {
            console.log(error); 
            this.succed = false;
            //this.get_gifts();
            this.errored= true;
            this.errors=[];
            this.errors.push({'message':'¡La categoría no se ha podido eliminar, Intentelo más tarde o contacte con el administrador!!!'});                
            
        })
        .finally(() => this.loading = false);
      },      
      edit_gift(index){    
          this.delete_errores_and_success();                    
          this.index_edit=index;             
      },
      save_gift(gift){       
        this.index_edit=-1;        
        axios.put(this.$server+'/api/v1/gifts/update/'+gift.id, gift)
          .then(response => {
              console.log(response); 
              this.succed  = true;
              this.errored = false;
              this.success = [];
              this.success.push({'message':'La categoria: '+gift.name+' ha sido actualizada correctamente.'});                                       
              //this.$router.push('/gift/list');
          })
          .catch(error => {
              console.log(error); 
              this.succed=false;             
              this.errored = true;
              this.errors = [];
              this.errors.push({'message':'No se ha podido actualizar la categoria, revise que los datos eran correctos.'})            
        })
        .finally(() => this.loading = false);  
      },
      cancel_edit(){
          this.index_edit=-1;          
      },      
      cancel_create(){
          this.create_gift=false;
          this.clean_form();
      },                 
      create_gift_(){          
          this.delete_errores_and_success();
          this.get_categories();
          this.create_gift = true;
      },
      delete_errores_and_success(){
        this.errored = false;
        this.succed=false;
      }
      ,
      onChangePage(pageOfItems) {
          // update page of items
          this.count_gifts_search = pageOfItems.length;
          this.pageOfItems = pageOfItems;
      },
      getBadge (state) {
        var status = state ? 'Active':'Inactive';
        console.log(status);  
        return status === 'Active' ? 'success'
            : status === 'Inactive' ? 'secondary'
            : status === 'Pending' ? 'warning'
                : status === 'Banned' ? 'danger' : 'primary'
        }
    },
    mounted() {
      this.get_gifts()
    }
  };  
</script>

<style scoped>
    .red{        
        color:red;
    }
    td {    
      width: 300px;  
    }
    th{
      width: 200px;
    }
</style>
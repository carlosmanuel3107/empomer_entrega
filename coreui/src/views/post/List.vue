<template>
  <div>     
    <CCard>      
      <CCardHeader>
        <h1><CIcon name="cil-list"/> <small>Lista de post_ias</small></h1>                            
      </CCardHeader>
      
      <CCardBody>        
          <div class="container-fluid" v-if="!create_post">
            <div class="row">
                <div class="col-10">
                    <div class="demo">
                      <form class="form-search">
                        <div class="input-group">                        
                            <input type="text" placeholder="Buscar post_ia" class="form-control col-lg-9" v-model="name">                           
                            <div class="input-group-append">
                              <button  type="button" class="btn btn-primary"><CIcon name="cil-search"/></button>
                            </div>                                                                              
                        </div>
                      </form>
                    </div>                    
                </div>

                <div class="col" >                    
                    <button id="btnAdd" v-on:click="create_post_()" class="btn btn-success btn text-right"><CIcon name="cil-plus"/></button>                    
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

        <div v-if="create_post">
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
                                                <label for="title" >Título:<span class="red">*</span></label>
                                                <input  type="text" class="form-control" v-model="post_.title" id="title" name=title  placeholder="Título del post">
                                            </div>
                                            <div class="col-md-6 mb-3">                    
                                                <label for="subject" >Asunto:<span class="red">*</span></label>
                                                <input  type="text" class="form-control" v-model="post_.subject" id="subject" name=subject  placeholder="Asunto">
                                            </div>                                                                                                                                                                                                             
                                        </div>             
                                        <div class="mb-3">
                                          <label for="writer" >Escritor:<span class="red">*</span></label>
                                          <input  type="text" class="form-control" v-model="post_.writer" id="writer" name=writer  placeholder="Redactor">
                                        </div>                                                                  

                                        <div class="mb-3">
                                          <label for="date" >Fecha:<span class="red">*</span></label>
                                          <input  type="text" class="form-control" v-model="post_.date" id="date" name=date  placeholder="aaaa-mm-dd">
                                        </div> 

                                         <div class="form-row ">
                                            <div class="col mb-3">
                                                <label for="message">Mensaje:<span class="red">*</span></label>
                                                <textarea placeholder="Cuerpo del post" class="form-control overflow-auto text_suspense" id="message" v-model="post_.message" name="message" rows="10" min="25" required></textarea>             
                                            </div>
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
                    <th scope="col">Titulo</th>                                        
                    <th scope="col">Asunto</th>
                    <th scope="col">Escritor</th>
                    <th scope="col">Mensaje</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Opciones</th>                                     
                  </tr>
                </thead>
          
                <tbody >                  
                  <tr v-for="(post,index) in pageOfItems" v-bind:key="post.id">  
                    <th scope="row">{{index+1}}</th> 
                    <td>
                      <div v-if = "index_edit != index">
                        <label @dblclick = "index_edit=-1"> {{post.title}} </label>
                      </div>
                      <input name="post_title" 
                        v-else-if = "index_edit == index" 
                        v-model = "post.title" 
                        
                        @keyup.enter = "index_edit=-1; save_post(post)">
                    </td> 
                    <td>
                      <div v-if = "index_edit != index">
                        <label @dblclick = "index_edit=-1"> {{post.subject}} </label>
                      </div>
                      <input name="post_subject" 
                        v-else-if = "index_edit == index" 
                        v-model = "post.subject" 
                        
                        @keyup.enter = "index_edit=-1; save_post(post)">
                    </td>
                    <td>
                      <div v-if = "index_edit != index">
                        <label @dblclick = "index_edit=-1"> {{post.writer}} </label>
                      </div>
                      <input name="post_writer" 
                        v-else-if = "index_edit == index" 
                        v-model = "post.writer" 
                        
                        @keyup.enter = "index_edit=-1; save_post(post)">
                    </td> 
                     <td>
                      <div v-if = "index_edit != index">
                        <label @dblclick = "index_edit=-1"> {{post.message}} </label>
                      </div>
                      <input name="post_message" 
                        v-else-if = "index_edit == index" 
                        v-model = "post.message" 
                        
                        @keyup.enter = "index_edit=-1; save_post(post)">
                    </td>  
                    <td>
                      <div v-if = "index_edit != index">
                        <label @dblclick = "index_edit=-1"> {{post.date}} </label>
                      </div>
                      <input name="post_date" 
                        v-else-if = "index_edit == index" 
                        v-model = "post.date" 
                        
                        @keyup.enter = "index_edit=-1; save_post(post)">
                    </td>                                                                                                                                             
                  
                    <td>
                        <div v-if="index_edit== index">
                            <div class="btn-toolbar text-right">                                                
                                <button  v-on:click="save_post(post)" class="btn btn-success btn-sm mr-3"><CIcon name="cil-check-alt"/></button>                                                                    
                                <button  v-on:click="cancel_edit()" class="btn btn-danger  btn-sm"><CIcon name="cil-x"/></button>                           
                            </div>
                        </div>                 

                        <div v-else>              
                            <div class="btn-toolbar text-right">                                                
                                <button  v-on:click="edit_post(index)" class="btn btn-primary btn-sm mr-3"><CIcon name="cil-pencil"/></button>                                                                    
                                <button  @click="darkModal = true, post_deleted = post" class="btn btn-danger  btn-sm"><CIcon name="cil-trash"/></button>                           
                            </div>                    
                        </div>                        
                    </td>
                  </tr>                  
                </tbody>                                
              </table>   

          </CRow>    
           <div class="card-footer row justify-content-end">
            <jw-pagination :items="search_posts" @changePage="onChangePage" :labels="customLabels"></jw-pagination>
          </div>               
                             
         <CModal
          :show.sync="darkModal"
          :no-close-on-backdrop="true"
          :centered="true"
          title="Modal title 2"
          size="lg"
          color="dark"
            >
            Está seguro(a) de eliminar la categoría de nombre: {{post_deleted.name}}.
          <template #header>
            <h6 class="modal-title"><CIcon name="cil-trash"/> Eliminar categoria</h6>
            <CButtonClose @click="darkModal = false" class="text-white"/>
          </template>
          <template #footer>
            <CButton @click="darkModal = false" color="danger">Cancelar</CButton>
            <CButton v-on:click="remove_post()" color="success">Eliminar</CButton>
          </template>
        </CModal>           
      </CCardBody>
       
    </CCard>    
  </div>               
</template>>

<script>
  import axios from "axios";
  import $ from 'jquery';
  
  const customLabels = {
    first: '<<',
    last: '>>',
    previous: '<',
    next: '>'
  };
  export default {
    name: 'Post_list', 
    components: {   
    },  
    data () {
      return {    
        posts : [],
        loading: false,
        errored: false,
        errors: [],
        succed: true,
        success: [],                                   
        darkModal: false,
        post_deleted:'',         
        pageOfItems: [],
        customLabels,    
        selectedUser: null,
        index_edit: -1,        
        post_:{
            title: '',
            subject: '',
            writer: '',
            message:'',
            date:''
        },
        create_post: false,
        count_attacks_search:0,
        name:''
        /*posts_prueba:[
          {
            id: 1,
            post_name: 'post_ia 1',
            state: true,    
            description: 'Categoria 1'                            
          },
          {
            id: 2,
            post_name: 'Categoria 2',
            state: true,    
            description: 'Categoria 2'                            
          },
          {
            id: 3,
            post_name: 'Categoria 3',
            state: true,    
            description: 'Categoria 3'                            
          },
        ]*/
      }
    }, 
    filters: {      
    },
    computed:{    
      search_posts: function () {       
        if (this.name==''){
          return this.posts;
        }else{                      
          return this.posts.filter((post) => post.title.includes(this.name));          
        }        
      }       
    },
    methods: {
      //...Vuex.mapActions('StoreAttack',['get_attacks', 'remove_attack','attack_aux']),
      clean_form(){
        this.post_.title='';
        this.post_.subject='';
        this.post_.writer='';
        this.post_.message='';
        this.post_.date='';        
      },
      send_form(e){          
          e.preventDefault();          
          axios.post(this.$server+'/api/v1/posts/create/', this.post_)
          .then(response => {
              console.log(response)
              this.succed=true;
              this.success = [];    
              this.success.push({'message': 'La post:'+this.post_.title+' ha sido registrado correctamente.'});
              this.create_post= false;
              this.clean_form();
              this.get_posts()
          })
          .catch(error => {              
              console.log(error);                
              this.errored = true;
              this.errors = [];
              this.errors.push({'message':'No se ha podido realizar el registro, revise que post no exista.'})            
          })
          .finally(() => this.loading = false);                           
      },
      get_posts(){
            const path = this.$server+'/api/v1/posts/';                
            axios.get(path).then(response => {    
                console.log(response.data.data[0].posts);   
                this.posts = response.data.data[0].posts;                            
            }).catch(error => {
                console.log(error);     
                this.errored= true;
                this.errors=[];
                this.errors.push({'message':'¡Lo sentimos los datos no estan disponibles en estos momentos, intentalo más tarde!!!'});                
            }).finally(() => this.loading = false);               
        },
      remove_post(){        
        this.darkModal = false;
        const path = this.$server+'/api/v1/posts/delete/'+this.post_deleted.id;
        axios.delete(path).then(response => {                           
            console.log(response);   
            this.succed = true;
            this.success=[];
            this.success.push({'message':'¡La post '+this.post_deleted.titlr+' ha sido eliminado!'})
            this.get_posts();
        })
        .catch(error => {
            console.log(error); 
            this.succed = false;
            //this.get_posts();
            this.errored= true;
            this.errors=[];
            this.errors.push({'message':'¡El post no se ha podido eliminar, Intentelo más tarde o contacte con el administrador!!!'});                
            
        })
        .finally(() => this.loading = false);
      },      
      edit_post(index){    
          this.delete_errores_and_success();                    
          this.index_edit=index;             
      },
      save_post(post){       
        this.index_edit=-1;        
        axios.put(this.$server+'/api/v1/posts/update/'+post.id, post)
          .then(response => {
              console.log(response); 
              this.succed  = true;
              this.errored = false;
              this.success = [];
              this.success.push({'message':'La categoria: '+post.titlr+' ha sido actualizado correctamente.'});                                       
              //this.$router.push('/post/list');
          })
          .catch(error => {
              console.log(error); 
              this.succed=false;             
              this.errored = true;
              this.errors = [];
              this.errors.push({'message':'No se ha podido actualizar el post, revise que los datos eran correctos.'})            
        })
        .finally(() => this.loading = false);  
      },
      cancel_edit(){
          this.index_edit=-1;          
      },      
      cancel_create(){
          this.create_post=false;
          this.clean_form();
      },                 
      create_post_(){          
          this.delete_errores_and_success();
          this.create_post = true;
      },
      delete_errores_and_success(){
        this.errored = false;
        this.succed=false;
      }
      ,
      onChangePage(pageOfItems) {
          // update page of items
          this.count_posts_search = pageOfItems.length;
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
      this.get_posts()      
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
    .text_suspense{
       width: 230px;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
    }
</style>
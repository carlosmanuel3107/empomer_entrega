<template>    
    <section class="section testimonial" id="testimonial">             
        <div class="container">            
            <h1 class="text-center">Comunicados dirigidos a la comunidad</h1>
        </div>  
        
        <div class="">
            <div class="demo center">
            <form class="form-search">
                <div class="input-group">
                <div class="input-group">
                    <input
                    type="text"
                    placeholder="Buscar prueba de publicaión"
                    class="form-control col-lg-9"
                    v-model="name"
                    />
                    <div class="input-group-append">
                    <button type="button" class="btn btn-primary">
                        <CIcon name="cil-search" />
                    </button>
                    </div>
                </div>
                </div>
            </form>
            </div>
        </div>        

        <div v-if="errored_l">
          <div v-for="(err, index) in errors_l" v-bind:key="index">
            <div class="alert alert-danger" role="alert">
              {{ err.message }}
            </div>
          </div>
        </div>
        <div v-else-if="succed_l">
          <div v-for="(succ, index) in success_l" v-bind:key="index">
            <div class="alert alert-success" role="alert">
              {{ succ.message }}
            </div>
          </div>
        </div>  

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Testimonial Slider -->
                    <div class="testimonial-slider owl-carousel owl-theme">
                        <div class="item" v-for="(post,index) in pageOfItems" v-bind:key="index">
                            <div class="block shadow">                                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="text-left font-weight-bold"><img src="@/assets/index/images/empomer_01.jpeg" alt="image" width="50" height="50">{{post.writer}}</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="text-right">{{post.date}}</h4>
                                    </div>
                                </div>    
                                <br>                                                            
                                <div>
                                    <h4 class="text-left font-italic"><strong class="font-weight-bold">Asunto: </strong> {{post.subject}}</h4>
                                    <br>
                                    <p class="text-justify">                                   
                                    {{post.message}}
                                    </p>                                                                                                
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer row justify-content-end">
                <jw-pagination
                    :items="search_posts"
                    @changePage="onChangePage"
                    :labels="customLabels"
                ></jw-pagination>
            </div>
        </div>
    </section>    
</template>


<script>

import axios from "axios";


const customLabels = {
  first: "<<",
  last: ">>",
  previous: "<",
  next: ">",
};

export default {
    name: 'Publications',
    components: {

    },
    data() {
        return {
            name: "",
            errored_l: false,
            errors_l: [],
            succed_l: true,
            success_l: [],
            loading_l: false,            
            post: [],
            count_posts_search: 0,
            pageOfItems: [],
            customLabels
        };
    },
    computed: {       
        search_posts: function () {
            console.log('searcgahsckjshd');
            if (this.name == "") {
                console.log(this.post);
                return this.post;
            } else {
                console.log(this.posts);
                return this.post.filter((post) => post.subject.includes(this.name));
            }
        },
    },
    methods: {
        get_post() {
            const path = this.$server+'/api/v1/posts/';
            axios.get(path).then((response) => {                
                if (response.data.success){
                    this.post = response.data.data[0].posts;
                    console.log(this.post.length);
                }else {
                    console.log('errore');
                }                 
            }).catch((error) => {
                console.log(error);
                this.setError("LO sentimos los datos no estan disponibles!");
            }).finally(() => (this.loading_l = false));
        },
        setError(_message){
            this.succed_l = false;
            this.errored_l = true;
            this.errors_l = [];
            this.errors_l.push({
                message:
                _message,
            });
        },
         onChangePage(pageOfItems) {
        // update page of items
            this.count_posts_search = pageOfItems.length;
            this.pageOfItems = pageOfItems;
        },
    },
    mounted() {
        this.get_post();
    }
}
</script>

<style scoped>  
.center {
  margin: auto;
  width: 50%;
}
</style>
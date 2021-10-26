<template>
  <div>
    <CCard>
      <CCardHeader>
        <h1>
          <CIcon name="cil-list" />
          <small>Lista de clientes</small>
        </h1>
      </CCardHeader>

      <CCardBody>
        <div class="container-fluid">
          <div class="row">
            <div class="col-10">
              <div class="demo">
                <form class="form-search">
                  <div class="input-group">
                    <div class="input-group">
                      <input
                        type="text"
                        placeholder="Buscar prueba de penetración"
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

            <div class="col">
              <button
                id="btnAdd"
                v-on:click="create_customer()"
                class="btn btn-success btn text-right"
              >
                <CIcon name="cil-plus" />
              </button>
            </div>
          </div>
        </div>

        <div class="row" style="margin-top: 10px">
          <div class="col-12">
            <table id="grid"></table>
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

        <CRow>
          <div class="table-responsive"></div>
          <table class="table table-striped">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Estracto</th>
                <th scope="col">Direccion</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Opciones</th>                
              </tr>
            </thead>

            <tbody>              
              <tr v-for="(customer, index) in pageOfItems" v-bind:key="customer.id">
                <th scope="row">{{ index + 1 }}</th>                
                <td>{{ customer.first_name }}</td>
                <td>{{ customer.last_name }}</td>
                <td>{{ customer.extract }}</td>
                <td>{{ customer.direction }}</td>
                <td>{{ customer.telephone }}</td>
                <td class="">
                  <div class="btn-toolbar text-right">
                    <!-- <i class="bi-eye" role="img" aria-label="Eye"></i>
                    <button
                      v-on:click="show_customer(customer)"
                      class="btn btn-success btn-sm mr-3"
                    >
                      <CIcon name="cib-cassandra" />
                    </button> -->
                    <button
                      v-on:click="edit_customer(customer)"
                      class="btn btn-primary btn-sm mr-3"
                    >
                      <CIcon name="cil-pencil" />
                    </button>
                    <button
                      v-on:click="
                        (darkModal = true),
                          (customer_name_deleted = customer.name),
                          (customer_id_deleted = customer.id)
                      "
                      class="btn btn-danger btn-sm"
                    >
                      <CIcon name="cil-trash" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </CRow>
        <div class="card-footer row justify-content-end">
          <jw-pagination
            :items="search_customers"
            @changePage="onChangePage"
            :labels="customLabels"
          ></jw-pagination>
        </div>

        <CModal
          :show.sync="darkModal"
          :no-close-on-backdrop="true"
          :centered="true"
          title="Modal title 2"
          size="lg"
          color="dark"
        >
          Está seguro(a) de eliminar el cliente:
          {{ customer_name_deleted }}
          <template #header>
            <h6 class="modal-title">
              <CIcon name="cil-trash" /> Eliminar cliente
            </h6>
            <CButtonClose @click="darkModal = false" class="text-white" />
          </template>
          <template #footer>
            <CButton @click="darkModal = false" color="danger"
              >Cancelar</CButton
            >
            <CButton v-on:click="remove_customer()" color="success"
              >Eliminar</CButton
            >
          </template>
        </CModal>
      </CCardBody>
    </CCard>
  </div>
</template>>

<script>
import axios from "axios";
import Vuex from "vuex";

const customLabels = {
  first: "<<",
  last: ">>",
  previous: "<",
  next: ">",
};
export default {
  name: "Customer_list",
  components: {},
  data() {
    return {
      name: "",
      errored_l: false,
      errors_l: [],
      succed_l: true,
      success_l: [],
      loading_l: false,
      darkModal: false,
      customer_name_deleted: "",
      customer_id_deleted: -1,
      pageOfItems: [],
      customLabels,
      customers: [],
      count_customers_search: 0,
    };
  },
  filters: {},
  computed: {
    ...Vuex.mapState("StoreCustomer", ["errored", "errors", "succed", "success"]),
    ...Vuex.mapGetters("StoreCustomer", ["get_success"]),
    search_customers: function () {
      if (this.name == "") {
        return this.customers;
      } else {
        return this.customers.filter((customer) => customer.name.includes(this.name));
      }
    },
  },
  methods: {
    //...Vuex.mapActions('Storecustomer',['get_customers', 'remove_customer','customer_aux','edit_loading']),
    ...Vuex.mapActions("StoreCustomer", ["edit_customers", "customer_aux"]),
    get_customers() {
      const path = "http://127.0.0.1:8000/api/v1/customers/";
      axios
        .get(path)
        .then((response) => {
          console.log(response.data.data[0].customers);
          this.customers = response.data.data[0].customers;
          this.edit_customers(this.customers);
        })
        .catch((error) => {
          console.log(error);
          this.succed_l = false;
          this.errored_l = true;
          this.errors_l = [];
          this.errors_l.push({
            message:
              "¡Lo sentimos los datos no estan disponibles en estos momentos, intentalo más tarde!!!",
          });
        })
        .finally(() => (this.loading_l = false));
    },
    remove_customer() {
      this.darkModal = false;
      const path ="http://127.0.0.1:8000/api/v1/customers/delete/" +
        this.customer_id_deleted;
      axios
        .delete(path)
        .then((response) => {
          console.log(response);
          this.errored_l = false;
          this.succed_l = true;
          this.success_l = [];
          this.success_l.push({
            message:
              "¡La prueba de penetración: " +
              this.customer_name_deleted +
              " ha sido eliminada correctamente!!!",
          });
          this.get_customers();
        })
        .catch((error) => {
          console.log(error);
          this.succed_l = false;
          this.errored_l = true;
          this.errors_l = [];
          this.errors_l.push({
            message:
              "¡No se ha podido eliminar la prueba de penetración: " +
              this.customer_name_deleted +
              "!, intentelo más tarde.",
          });
        })
        .finally(() => (this.loading_l = false));
    },
    /**
     * Editar ataque con id
     */
    edit_customer(customer) {
      this.customer_aux(customer);
      this.$router.push({ path: "/customer/edit/" + customer.id });
    },
    /**
     * Mostrar un ataque ataque con id
     */
    show_customer(customer) {
      this.customer_aux(customer);
      this.$router.push({ path: "/customer/show/" + customer.id });
      //this.$router.push('/customer/edit')
    },
    /**
     * Editar ataque con id
     */
    create_customer() {
      this.$router.push("/customer/create");
      //this.$router.push('/customer/edit')
    },
    onChangePage(pageOfItems) {
      // update page of items
      this.count_customers_search = pageOfItems.length;
      this.pageOfItems = pageOfItems;
    },
    set_errors() {
      this.succed_l = this.succed;
      this.success_l = this.succed_l ? this.get_success : [];
    },
  },
  mounted() {
    this.set_errors();
    this.get_customers();
  },
};
</script>

<style scoped>
td {
  width: 400px;
}
th {
  width: 200px;
}
</style>







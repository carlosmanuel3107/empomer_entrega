import axios from "axios";

export default{
    namespaced: true,
    state: {         
        categories: [],
        errored: false,
        errors: [],
        succed: true,
        success: [],      
        loading: false,
        customers: [],
        customer:{
            // name: '',
            // state: false,    
            // description: '',
            // price: 0,
            // owas_id: '',            
            // script: '',
            // category: ''                                    
        }           
    },
    mutations: { 
        fill_in_customers(state, customers_actions){
            state.customers = customers_actions
        },
        set_errors(state, error){
            state.error=[];
            state.errors.push(error)
        },
        add_errors(state, error){
            state.errors.push(error)
        },
        set_errored(state, errored){
            state.errored=errored
        },
        set_loading(state, loading){
            state.loading=loading
        },
        set_success(state, success){
            state.success=[];
            state.success.push(success)
        },        
        add_success(state, success){
            state.success.push(success)
        },
        set_succed(state, succed){
            state.succed=succed
        },
        customer_aux({commit}, customer){
            commit('set_customer', customer);
        },
        set_customer(state,customer){
            state.customer=customer;
        }
    },
    actions: {      
        add_message_success({commit}, success){
            commit('set_succed', true);                  
            commit('set_success', success); 
        },
        customer_aux({commit}, customer){
            commit('set_customer', customer);
        }
    },
    getters: {
        get_success: state => {
            return state.success;
        },
    }
    
} 
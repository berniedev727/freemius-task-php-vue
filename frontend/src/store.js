import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
import router from './router'

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    products: [],
    detailproduct : {}
  },
  mutations: {
    SEARCH_PRODUCT(state, searechproducts) {
      state.products = searechproducts.map(item =>({
        id: item.id,
        title: item.title,
        description: item.description,
        price: item.price,
        vendor_name: item.vendor_name,
        vendor_support_email: item.vendor_support_email
      }));
    },
    DETAIL_PRODUCT(state, product) {
      state.detailproduct = product;
    },
    EMPTY_PRODUCT(state) {
      state.products = [];
    }
  },
  actions: {
    addProduct({ commit }, product) {

      axios
        .post("http://localhost/api/create.php", product)
        .then(response => response.data)
        .then(product => {
          router.push({ path: '/' })
        })
        .catch(err => {
          console.log(err);
        });
    },
    searchProduct({commit}, query) {
      axios
        .get("http://localhost/api/search.php?query=" + query)
        .then(response => response.data)
        .then(products => {
          
          commit("SEARCH_PRODUCT", products);
        })
        .catch(err => {
          console.log(err);
          if(err.response.data.message === "Product does not exist.") {
            commit("EMPTY_PRODUCT");
          }
        });
    },
    detailProduct( { commit }, id) {
      axios
        .get("http://localhost/api/read.php?id=" + id)
        .then(response => response.data)
        .then(product => {
          commit("DETAIL_PRODUCT", product);
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  getters: {
    products: state => state.products
  }
});

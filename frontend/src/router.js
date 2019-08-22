import Vue from "vue";
import Router from "vue-router";
import ListProducts from "./views/ListProducts.vue";
import CreateProduct from "./views/CreateProduct.vue";
import ProductDetails from "./views/ProductDetails.vue";

Vue.use(Router);

export default new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/",
      name: "listproducts",
      component: ListProducts
    },
    {
      path: "/create",
      name: "creatproduct",
      component: CreateProduct
    },
    {
      path: "/:id",
      name: "productdetails",
      component: ProductDetails
    }
  ]
});

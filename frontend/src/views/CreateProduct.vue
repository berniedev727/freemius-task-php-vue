<template>
    <div class="container">
        <h1>Create Product</h1>
        <form @submit.prevent="addProduct">
             
            <b-row class="my-1" v-if="errors.length">
                <b-col sm="12">
                    <h1>Please correct the following error(s):</h1>
                </b-col>
                <b-col sm="12" v-for="error in errors">
                    <span>{{ error }}</span>
                </b-col>
                
            </b-row>
            <b-row class="my-1">
                <b-col sm="2">
                    <label for="title">Title:</label>
                </b-col>
                <b-col sm="10">
                    <b-form-input id="title" name="title" type="text" v-model="product.title" placeholder="Enter the product title"></b-form-input>
                </b-col>
            </b-row>
            <b-row class="my-1">
                <b-col sm="2">
                    <label for="description">Descriptions:</label>
                </b-col>
                <b-col sm="10">
                    <b-form-textarea id="description" v-model="product.description" placeholder="Enter the description" rows="3" max-rows="6"></b-form-textarea>
                </b-col>

            </b-row>
            <b-row class="my-1">
                <b-col sm="2">
                    <label for="price">Price:</label>
                </b-col>
                <b-col sm="10">
                    <b-form-input id="price" name="price" type="number" v-model="product.price" placeholder="Enter the price"></b-form-input>
                </b-col>
            </b-row>
            <b-row class="my-1">
                <b-col sm="2">
                    <label for="vendor_name">Vendor's Name:</label>
                </b-col>
                <b-col sm="10">
                    <b-form-input id="vendor_name" name="vendor_name" type="text" v-model="product.vendor_name" placeholder="Enter the Vendor's name"></b-form-input>
                </b-col>
            </b-row>
            <b-row class="my-1">
                <b-col sm="2">
                    <label for="email">Vendor's Email:</label>
                </b-col>
                <b-col sm="10">
                    <b-form-input id="email" name="email" type="email" v-model="product.vendor_support_email" placeholder="Enter the Vendor's Email"></b-form-input>
                </b-col>
            </b-row>
            <div class="form-group" id="btn">
                <button type="submit" class="btn btn-success">Create</button>
                <a type="button" href="/" class="btn btn-primary">Cancel</a>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: [],
            product: {}
        }
    },
    methods: {
        addProduct(){
            this.errors = [];

            if (!this.product.title) {
                this.errors.push('Name required.');
            }
            if (!this.product.description) {
                this.errors.push('Description required.');
            }
            if (!this.product.price) {
                this.errors.push('Price required.');
            }
            if (!this.product.vendor_name) {
                this.errors.push('Vendor Name required.');
            }
            if (!this.product.vendor_support_email) {
                this.errors.push('Vendor Support Email required.');
            } else if (!this.validEmail(this.product.vendor_support_email)) {
                this.errors.push('Valid email required.');
            }

            if (this.errors.length) {
                return;
            }
            
            this.$store.dispatch('addProduct', this.product);
            //this.$router.push("/");
        },
        validEmail: function (email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    }
}
</script>

<style>
span {
    color: red;
}
a {
    margin-left: 10px;
}
</style>

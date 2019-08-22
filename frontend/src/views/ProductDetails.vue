<template>
    <div>
        <h1>Product details</h1>
        <div>ID: {{productDetail.id}}</div>
        <div>Title: {{productDetail.title}}</div>
        <div>Description: {{productDetail.description}}</div>
        <div>Price: {{productDetail.price}}</div>
        <div>Vendor's Name: {{productDetail.vendor_name}}</div>
        <div>Vendor's Support Email: {{productDetail.vendor_support_email}}</div>
    </div>
</template>

<script>
export default {
    mounted() {
        let productId = this.$route.params.id;
        this.$store.dispatch("detailProduct", productId);
        
    },
    computed: {
        productDetail() {
            return this.$store.state.detailproduct;
        }
    }
}
</script>

<style>

</style>

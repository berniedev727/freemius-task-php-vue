<template>
  <b-container fluid>
    <!-- User Interface controls -->
    <form @submit.prevent="searchProduct">
      <b-col md="3" class="my-1">
        <b-form-input id="search" name="search" type="text" v-model="search" placeholder="Search" ></b-form-input>
      </b-col>
    </form>

    <!-- Main table element -->
    <b-table
      show-empty
      stacked="md"
      :items="products"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      :sort-direction="sortDirection"
      @row-clicked="myRowClickHandler"
    >
      <template slot="row-details" slot-scope="row">
        <b-card>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
          </ul>
        </b-card>
      </template>
    </b-table>

    <b-row>
      <b-col md="6" class="my-1">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          class="my-0"
        ></b-pagination>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
  export default {
    data() {
      return {
        items: [],
        fields: [
          { key: 'title', label: 'Title', sortable: true, sortDirection: 'asc', class: 'text-center' },
          { key: 'description', label: 'Description', sortable: true, class: 'text-center' },
          { key: 'price', label: 'Price', sortable: true, sortDirection: 'asc', class: 'text-center' },
          { key: 'vendor_name', label: 'Vendor Name', sortable: true, sortDirection: 'asc', class: 'text-center' },
          { key: 'vendor_support_email', label: 'Vendor Support Email', sortable: true, sortDirection: 'asc', class: 'text-center' }
        ],

        currentPage: 1,
        perPage: 5,
        pageOptions: [5, 10, 15],
        sortBy: null,
        sortDesc: false,
        sortDirection: 'asc',
        filter: null,
        infoModal: {
          id: 'info-modal',
          title: '',
          content: ''
        },
        search: ''
      }
    },
    computed: {
      sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
          })
      },
      products() {
          return this.$store.getters.products;
      },
      totalRows () {
        return this.$store.getters.products.length;
      }
    },
    mounted() {
      // Set the initial number of items
      this.$store.dispatch('searchProduct', this.search);
    },
    methods: {
      myRowClickHandler(item, index, event) {
          this.$router.push({
                name: "productdetails",
                params: { id: item.id }
            });
          
      },
    
      searchProduct() {
        this.$store.dispatch('searchProduct', this.search);
      }
    }
  }
</script>
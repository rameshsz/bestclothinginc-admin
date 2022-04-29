
const app = Vue.createApp({
    data() {
        return {
            customers: [],
            products: [],
            showCustomers: false,
            showProducts: true,
            productEdit: false
        };
    },
    methods: {
        productList: function () {
            this.showCustomers = false;
            axios
                .get("./listProducts.php")
                .then((response) => {
                    this.products = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.showProducts = true;
        },
        customerList: function () {
            this.showProducts = false;
            axios
                .get("./listCustomers.php")
                .then((response) => {
                    this.customers = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.showCustomers = true;
        },
        removeProduct: function (event) {
            const prod_itemid = { prod_itemid: event.target.id };
            axios
                .post("./removeProduct.php",
                    prod_itemid)
                .catch(function (error) {
                    console.log(error);
                });
        },
        removeCustomer: function (event) {
            const id = { id: event.target.id };
            axios
                .post("./removeCustomer.php",
                    id)
                .catch(function (error) {
                    console.log(error);
                });
        },
        updateProduct: function (event) {
            const property ={property: event.target.class};
            const value = {value:event.target.value};
            const id = {id:event.target.id};
            axios
                .post("./updateProduct.php",
                    property,value,id)
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
    created: function () {
        this.productList()
    }
});
app.mount('#app');

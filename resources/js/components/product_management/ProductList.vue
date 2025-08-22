<template>
    <div class="products-list">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Products Management</h1>
            <router-link to="/admin/products/create" class="btn btn-primary">Add New Product</router-link>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.id }}</td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.category?.name }}</td>
                    <td>${{ product.price }}</td>
                    <td>{{ product.quantity }}</td>
                    <td>
              <span :class="['badge', product.is_visible ? 'bg-success' : 'bg-secondary']">
                {{ product.is_visible ? 'Visible' : 'Hidden' }}
              </span>
                    </td>
                    <td>
                        <router-link :to="`/admin/products/${product.id}/edit`" class="btn btn-sm btn-outline-primary">Edit</router-link>
                        <button @click="deleteProduct(product.id)" class="btn btn-sm btn-outline-danger">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            products: []
        }
    },
    mounted() {
        this.fetchProducts();
    },
    methods: {
        fetchProducts() {
            axios.get('/api/admin/products')
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                axios.delete(`/api/admin/products/${id}`)
                    .then(() => {
                        this.fetchProducts();
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    }
}
</script>

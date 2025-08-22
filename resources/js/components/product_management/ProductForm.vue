<template>
    <div class="product-form">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">{{ editing ? 'Edit Product' : 'Create New Product' }}</h1>
        </div>

        <form @submit.prevent="submitForm">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">Basic Information</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" v-model="form.name" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" v-model="form.description" rows="4" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price ($)</label>
                                        <input type="number" step="0.01" class="form-control" id="price" v-model="form.price" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="compare_price" class="form-label">Compare Price ($)</label>
                                        <input type="number" step="0.01" class="form-control" id="compare_price" v-model="form.compare_price">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">SKU</label>
                                        <input type="text" class="form-control" id="sku" v-model="form.sku" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" v-model="form.quantity" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">Organization</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" v-model="form.category_id" required>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <select class="form-select" id="brand" v-model="form.brand_id">
                                    <option value="">Select Brand</option>
                                    <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                        {{ brand.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_visible" v-model="form.is_visible">
                                    <label class="form-check-label" for="is_visible">
                                        Visible on store
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ editing ? 'Update' : 'Create' }}</button>
            <router-link to="/admin/products" class="btn btn-secondary">Cancel</router-link>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        productId: {
            type: [String, Number],
            default: null
        }
    },
    data() {
        return {
            editing: false,
            categories: [],
            brands: [],
            form: {
                name: '',
                description: '',
                price: 0,
                compare_price: null,
                category_id: '',
                brand_id: null,
                sku: '',
                quantity: 0,
                is_visible: true
            }
        }
    },
    mounted() {
        this.fetchFormData();

        if (this.productId) {
            this.editing = true;
            this.fetchProduct();
        }
    },
    methods: {
        fetchFormData() {
            axios.get('/api/admin/products/create')
                .then(response => {
                    this.categories = response.data.categories;
                    this.brands = response.data.brands;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchProduct() {
            axios.get(`/api/admin/products/${this.productId}/edit`)
                .then(response => {
                    this.form = response.data.product;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        submitForm() {
            const url = this.editing
                ? `/api/admin/products/${this.productId}`
                : '/api/admin/products';

            const method = this.editing ? 'put' : 'post';

            axios[method](url, this.form)
                .then(() => {
                    this.$router.push('/admin/products');
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>

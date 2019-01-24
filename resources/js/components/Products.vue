<template>
    <div>
        <h2>Products</h2>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ul class="pagination">
                        <li v-bind:class="{disabled:!pagination.first_page_url}" class="page-item"><a href="#"
                                                                                                      @click="fetchProducts(pagination.first_page_url)"
                                                                                                      class="page-link">&laquo;</a>
                        </li>
                        <li v-bind:class="{disabled:!pagination.prev_page_url}" class="page-item"><a href="#"
                                                                                                     @click="fetchProducts(pagination.prev_page_url)"
                                                                                                     class="page-link">&lt;</a>
                        </li>
                        <li v-for="n in pagination.last_page" v-bind:key="n"
                            v-bind:class="{active:pagination.current_page === n}" class="page-item"><a href="#"
                                                                                                       @click="fetchProducts(pagination.path_page + n)"
                                                                                                       class="page-link">{{n}}</a>
                        </li>
                        <li v-bind:class="{disabled:!pagination.next_page_url}" class="page-item"><a href="#"
                                                                                                     @click="fetchProducts(pagination.next_page_url)"
                                                                                                     class="page-link">&gt;</a>
                        </li>
                        <li v-bind:class="{disabled:!pagination.last_page_url}" class="page-item"><a href="#"
                                                                                                     @click="fetchProducts(pagination.last_page_url)"
                                                                                                     class="page-link">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="col-md-4">
            Page: {{pagination.from_page}} - {{pagination.to_page}}
            Total: {{pagination.total_page}}
        </div>
        <hr>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add product</button>
        <hr>
        <div class="table table-bordered">
            <table width="100%" cellspacing="0" cellpadding="4" border="1">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>&#9998;</th>
                    <th>&#10008;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products"
                    v-bind:key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.category.name }}</td>
                    <td>{{ product.price }}</td>
                    <td width="100%">{{ product.description }}</td>
                    <td>
                        <button @click="editProduct(product)" class="btn btn-dark" data-toggle="modal" data-target="#myModal">Edit</button>
                    </td>
                    <td>
                        <button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addProduct" class="mb-3">
                            <h4>Name</h4>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Name" v-model="product.name">
                            </div>
                            <h4>Category</h4>
                            <div class="form-group">
                                <select class="form-control" id="category-drop-down" name="" v-model="product.category_id">
                                    <option disabled value="">Please select category</option>
                                    <option value="1">Процессор</option>
                                    <option value="2">Видеокарта</option>
                                    <option value="3">Материнская плата</option>
                                    <option value="4">Оперативная память</option>
                                </select>
                            </div>
                            <h4>Price</h4>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Price" v-model="product.price">
                            </div>
                            <h4>Description</h4>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Description" v-model="product.description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-light btn-block">Save</button>
                        </form>
                        <button @click="clearForm()" class="btn btn-danger btn-block">Cancel</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                products: [],
                product: {
                    id: '',
                    name: '',
                    category_id: '',
                    price: '',
                    description: '',
                    category: {
                        id: '',
                        name: '',
                    }
                },
                product_id: '',
                pagination: {},
                edit: false
            }
        },
        created() {
            this.fetchProducts();
        },
        methods: {
            fetchProducts(pagi) {
                pagi = pagi || 'api/products';
                fetch(pagi)
                    .then(res => res.json())
                    .then(res => {
                        this.products = res.data;
                        this.pagination = {
                            current_page: res.current_page,
                            last_page: res.last_page,
                            from_page: res.from,
                            to_page: res.to,
                            total_page: res.total,
                            path_page: res.path + "?page=",
                            first_page_url: res.first_page_url,
                            last_page_url: res.last_page_url,
                            prev_page_url: res.prev_page_url,
                            next_page_url: res.next_page_url
                        }
                    })
            },
            deleteProduct(id) {
                if (confirm('Are You Sure?')) {
                    fetch(`api/products/${id}`, {
                        method: 'delete'
                    })
                        .then(res => res.json());
                    this.fetchProducts()
                        .catch(err => console.log(err));
                }
            },
            addProduct() {
                if (this.edit === false) {
                    // Add
                    fetch('api/create', {
                        method: 'post',
                        body: JSON.stringify(this.product),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json());
                    this.clearForm();
                    alert('Product Added');
                    this.fetchProducts()
                        .catch(err => console.log(err));
                } else {
                    // Update
                    fetch('api/update', {
                        method: 'put',
                        body: JSON.stringify(this.product),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json());
                    this.clearForm();
                    alert('Products Updated');
                    this.fetchProducts()
                        .catch(err => console.log(err));
                }
            },
            editProduct(product) {
                this.edit = true;
                this.product.id = product.id;
                this.product.name = product.name;
                this.product.category_id = product.category_id;
                this.product.price = product.price;
                this.product.description = product.description;
            },
            clearForm() {
                this.edit = false;
                this.product.id = null;
                this.product.name = null;
                this.product.category_id = null;
                this.product.price = '';
                this.product.description = '';
            }
        }
    };
</script>

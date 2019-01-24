<template>

    <div class="form-group" id = "category">
        <select class= "form-control" id="category-drop-down" name="" v-model = "CategoryID">
            <option disabled value="">Please select category</option>
            <option value="1">Процессор</option>
            <option value="2">Видеокарта</option>
            <option value="3">Материнская плата</option>
            <option value="4">Оперативная память</option>
        </select>
        <hr>
        <div class="form-group" @click = "fetchCategory">
            <button class="btn btn-dark btn-block">Choose Category</button>
        </div>
        <hr>
        <div class="table table-bordered">
            <table width="100%" cellspacing="0" cellpadding="4" border="1">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th width="85%">Description</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for = "category in categories.product">
                    <td>{{ category.name}}</td>
                    <td>{{ category.price }}</td>
                    <td width="85%">{{ category.description }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Category',
        data() {
            return {
                CategoryID: '',
                categories: {
                    product: []
                }
            }
        },
        methods: {
            fetchCategory() {
                let category = this.CategoryID;
                fetch(`/api/category/${category}`, {
                    method: 'GET'
                }).then(
                    response => response.json())
                    .then(json => this.categories = json)
            }
        }
    }
</script>
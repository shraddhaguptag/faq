<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel-heading">
                    <router-link :to="{ name: 'create' }" class="btn btn-primary addButton">
                        + Add Category
                    </router-link>
                    <h2 class="heading">Category List</h2>
                    <router-link :to="{ name: 'create-faq' }" class="btn btn-secondary">
                        + Add Faq
                    </router-link>
                </div>

                <table class="table table-bordered table-striped ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr v-for="(category, index) in categories.data" :key="index" v-bind:key="categories.id">
                            <td>{{ category.name }}</td>
                            <td>{{ category.status }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <router-link :to="{ name: 'edit',params: { id: category.id } }" class="btn btn-success">Edit</router-link> &nbsp;
                                    <button class="btn btn-danger" @click="deleteCategory(category.id)">Delete</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
 
<script>
export default {
    name: 'Category List',
    data() {
        return {
            categories: [],
        }
    },
    created() {
        this.getList();
    },

    methods: {
        async getList() {

            await axios.get('/api/category').then(response => {
                this.categories = response.data;
            }).catch(error => {
                console.log(error)
                this.categories = [];
            })
            console.log(this.categories)
        },

        deleteCategory(id) {
            if(confirm("Are you sure to delete this category ?")){
                axios.delete(`/api/category/${id}`).then(response=>{
                    this.getList()
                }).catch(error=>{
                    console.log(error)
                })
            }
        }
    }
}
</script>
<style>
.addButton {
    float: right;
    font-size: 18px;
    margin-top: 23px;
    cursor: pointer;
    font-weight: 600;
    margin-bottom: 35px;
}

.heading {
    text-align: center;
    margin-top: 23px;
}
</style>
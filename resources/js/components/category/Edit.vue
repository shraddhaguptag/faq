<template>
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col-lg-10 col-md-10 form-group backButton">
                <router-link :to="{ name: 'category-list' }" class="btn btn-primary ">
                    Back to List
                </router-link>
            </div>
            <div class="col-lg-10 col-md-10 form-group">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Edit Category</h3>
                    </div>

                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-8 col-md-8 form-group">
                                    <label for="name">Category Names:</label>
                                    <input type="text" name="name" id="name" placeholder="Category name..."
                                        class="form-control" v-model="category.name">
                                </div>
                                <div class="col-lg-4 col-md-4 form-group">
                                    <label>Status:</label>
                                    <select class='form-control' v-model='category.status' name="status">
                                        <option :value="1" color="green-darken-3">Enable</option>
                                        <option :value="0">Disable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 form-group">
                                <button type="submit" class="btn btn-primary" id="update"
                                    @click.stop.prevent="update">Update</button> &NonBreakingSpace; &NonBreakingSpace;
                                <button type="button" class="btn btn-secondary" id="test"
                                    @click.stop.prevent="reset">Reset</button>
                            </div>
                            <div class="col-md-6 form-group" v-if="errors.length">
                                <p><b>Please correct the following error(s):</b>
                                <ul>
                                    <li style="color: red;" v-for="error in errors" :key="error">{{ error }}</li>
                                </ul>
                                </p>
                            </div>
                            <div class="col-md-4 form-group" text-align="center" style="color: green;" v-if="success">
                                Category updated successfully.</div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Edit Category',
    data() {
        return {
            category: {
                name: '',
                status: '',
            },
            errors: [],
            success: false,
        }
    },

    created() {
        this.showCategory();
    },
    methods: {

        //show details of particular notification which needs to be edit
        async showCategory() {
            await axios.get(`/api/category/${this.$route.params.id}`).then(response => {
                const { name, status } = response.data
                this.category.name = name,
                    this.category.status = status
                console.log(this.category.name)
            }).catch(error => {
                console.log(error)
            })
        },

        //update category
        async update() {
            this.errors = [];
            this.category.name = this.category.name.trim();
            this.category.status = this.category.status;
            if (!this.category.name) {
                this.errors.push("Category is required.");
            }

            if (this.errors.length) {
                return false;
            }
            await axios.put(`/api/category/${this.$route.params.id}`, this.category).then(response => {
                this.$router.push({ name: "category-list" })
            }).catch((error) => {
                this.errors.push(error.response.data.message);
            });
        },
        // reset all fields of form
        reset() {
            this.category.name = '';
        },

    }
}
</script>
<style>
.backButton {
    float: right !important;
    font-size: 18px;
    margin-top: 23px;
    cursor: pointer;
    font-weight: 600;
}
</style>
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
                        <h3>Add Category</h3>
                    </div>

                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-8 col-md-8 form-group">
                                    <label for="name">Category Name:</label>
                                    <input type="text" name="name" id="name" placeholder="Category name..."
                                        class="form-control" v-model="category.name">
                                </div>

                            </div>

                            <div class="col-lg-12 form-group">
                                <button type="submit" class="btn btn-primary" id="submit"
                                    @click.stop.prevent="submit">Save</button> &NonBreakingSpace; &NonBreakingSpace;
                                <button type="button" class="btn btn-secondary" id="reset"
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
                                category create successfully.</div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'Create Category',
    data() {
        return {
            category: {
                name: '',
            },
            errors: [],
            success: false,
        }
    },

    methods: {

        //store category 
        submit() {
            this.errors = [];
            this.category.name = this.category.name.trim();
            if (!this.category.name) {
                this.errors.push("Category name is required.");
            }

            if (this.errors.length) {
                return false;
            }
            axios
                .post('/api/category', this.category)
                .then((response) => {
                    console.log(response)
                    if (response.status == 201) {
                        this.success = true,
                            this.$router.push({ name: 'category-list' })
                    }
                })
                .catch((error) => {
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

.ck-editor__editable {
    min-height: 200px;
}
</style>
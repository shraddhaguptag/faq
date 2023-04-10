<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel-heading">
                    <router-link :to="{ name: 'create-faq' }" class="btn btn-primary addButton">
                        + Add Question
                    </router-link>
                    <h2 class="heading">Question List</h2>
                    <router-link :to="{ name: 'create' }" class="btn btn-secondary">
                        + Add Category
                    </router-link>
                </div>

                <table class="table table-bordered table-striped ">
                    <thead>
                        <tr style="text-align: center;">
                            <th>Question</th>
                            <th>Category</th>
                            <th>Answer</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr v-for="(question, index) in questions.data" :key="index" v-bind:key="question.id">
                            <td>{{ question.title }}</td>
                            <td v-if="question.category">{{ question.category.name }}</td>
                            <td>
                                <p v-html="truncate(question.answer,100)"></p>
                            </td>
                            <td>{{ question.status }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <router-link :to="{ name: 'edit-faq',params: { id: question.id } }" class="btn btn-success">Edit</router-link> &nbsp;
                                    <button class="btn btn-danger" @click="deleteQuestion(question.id)">Delete</button>
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
    name: 'Question List',
    data() {
        return {
            questions: [],
        }
    },
    created() {
        this.getList();
    },

    methods: {
        async getList() {
            await axios.get('/api/questions').then(response => {
                this.questions = response.data;
            }).catch(error => {
                console.log(error)
                this.questions = [];
            })
            console.log(this.questions)
        },
        //method to delete question
        deleteQuestion(id) {
            if(confirm("Are you sure to delete this question ?")){
                axios.delete(`/api/questions/${id}`).then(response=>{
                    this.getList()
                }).catch(error=>{
                    console.log(error)
                })
            }
        },
        //method to truncate long answer description within a certain range
        truncate(value, length) {
            if (value.length > length) {
                return value.substring(0, length) + "...";
            } else {
                return value;
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
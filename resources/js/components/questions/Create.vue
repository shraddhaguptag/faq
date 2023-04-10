<template>
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col-lg-10 col-md-10 form-group backButton">
                <router-link :to="{ name: 'faq-list' }" class="btn btn-primary ">
                    Back to Questions
                </router-link>
            </div>
            <div class="col-lg-10 col-md-10 form-group">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Add Q&A</h3>
                    </div>

                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" name="title" id="title" placeholder="Title" class="form-control"
                                        v-model="question.title">
                                </div>
                                <div class="col-lg-6 col-md-6 form-group">
                                    <label>Select Category:</label>
                                    <select class='form-control' v-model='question.category_id' name="category_id">
                                        <option value='0'>Select Category</option>
                                        <option v-for='data in categories.data' :value='data.id'>{{ data.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-10 form-group">
                                <label for="answer">Answer:</label>
                                <ckeditor :editor="editor" v-model="question.answer" :config="editorConfig"></ckeditor>
                            </div>
                            <div class="col-lg-12 form-group">
                                <button type="submit" class="btn btn-primary" id="submit"
                                    @click.stop.prevent="submit">Save</button> &NonBreakingSpace; &NonBreakingSpace;
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
                                Question added successfully.</div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
//import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    name: 'Create Question',
    data() {
        return {
            category: 0,
            categories: [],
            question: {
                title: '',
                answer: '',
                category_id: '',
            },
            errors: [],
            success: false,
            editor: ClassicEditor,
            editorConfig: {
                toolbar: {
                    items: [
                        'bold', 'italic', '|', 'link',
                        'heading', 'bulletedList', 'numberedList',
                        'blockQuote',
                        'undo',
                        'redo', 'outdent', 'indent'//,'uploadImage','mediaEmbed'
                    ],
                    shouldNotGroupWhenFull: true
                },
                image: {
                    styles: [
                        'alignCenter',
                        'alignLeft',
                        'alignRight'
                    ],
                    toolbar: [
                        'imageTextAlternative', 'toggleImageCaption', '|',
                        'imageStyle:inline', 'imageStyle:wrapText', 'imageStyle:breakText', 'imageStyle:side', '|',
                    ],
                    insert: {
                        integrations: [
                            'insertImageViaUrl'
                        ]
                    }
                },
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },


                /*mediaEmbed: {
                    removeProviders: [ 'instagram', 'twitter', 'googleMaps', 'flickr', 'facebook' ]
                },*/
                // The configuration of the editor.

            }
        }
    },

    created() {
        this.getCategories();
    },

    methods: {
        //get categories
        async getCategories() {
            await axios.get('/api/categories').then(response => {
                this.categories = response.data;
            }).catch(error => {
                console.log(error)
                this.categories = [];
            })
        },

        //store question
        submit() {
           // alert("categorry id "+ this.question.category_id)
            this.errors = [];
            this.question.title = this.question.title.trim();
            this.question.answer = this.question.answer.trim();
            this.question.category_id = this.question.category_id;

            if (!this.question.title) {
                this.errors.push("Question title is required.");
            }

            if (!this.question.answer) {
                this.errors.push("Answer is required.");
            }

            if(!this.question.category_id || this.question.category_id == 0) {
                this.errors.push("Category name is required.");
            }

            if (this.errors.length) {
                return false;
            }
            axios
                .post('/api/questions', this.question)
                .then(response => (
                    this.success = true,
                    this.$router.push({ name: 'faq-list' })
                ))
                .catch((error) => {
                    this.errors.push(error.response.data.message);
                });
        },

        // reset all fields of form
        reset() {
            this.question.title = '';
            this.question.answer = '';
            this.question.category_id = '';
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
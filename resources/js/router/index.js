import { createRouter, createWebHistory } from 'vue-router'

//Category Pages
const CreateCategory = () => import("@/components/category/Create.vue");
const EditCategory = () => import("@/components/category/Edit.vue");
const CategoryList = () => import("@/components/category/List.vue");

//FAQ Pages
const CreateQuestion = () => import("@/components/questions/Create.vue");
const EditQuestion = () => import("@/components/questions/Edit.vue");
const QuestionList = () => import("@/components/questions/List.vue");
const FAQ = () => import("@/components/questions/FAQ.vue");

var myrouter = new createRouter({
  history: createWebHistory(import.meta.env.VITE_APP_PATH),
  routes: [
    {
      name: 'create',
      path: '/create',
      component: CreateCategory
    },
    {
      name: 'category-list',
      path: '/category/list',
      component: CategoryList
    },
    {
      name: 'edit',
      path: '/edit/:id',
      component: EditCategory
    },
    {
      name: 'create-faq',
      path: '/faq/create',
      component: CreateQuestion
    },
    {
      name: 'faq-list',
      path: '/faq/list',
      component: QuestionList
    },
    {
      name: 'edit-faq',
      path: '/faq/edit/:id',
      component: EditQuestion
    },
    {
      name: 'home',
      path: '/',
      component: FAQ
    },
  ]
});

export default myrouter;

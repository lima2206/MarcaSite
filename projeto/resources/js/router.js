import { createRouter, createWebHistory } from "vue-router";
import HomePage from "./Pages/HomePage.vue";
import TestPage from "./Pages/TestPage.vue";

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage
  },
  {
    path: '/test',
    name: 'test',
    component: TestPage
  }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
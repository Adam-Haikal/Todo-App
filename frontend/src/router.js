import { createRouter, createWebHistory } from "vue-router";
import DefaultLayout from "@/components/DefaultLayout.vue";
import NotFound from "@/views/NotFound.vue";
import HomeView from "@/views/HomeView.vue";
import ListsView from "@/views/ListsView.vue";
import ForgotPassword from "@/views/auth/ForgotPassword.vue";
import RegisterView from "@/views/auth/RegisterView.vue";
import LoginView from "@/views/auth/LoginView.vue";
import ImportantView from "@/views/ImportantView.vue";
import PlannedView from "@/views/PlannedView.vue";
import AssignedView from "@/views/AssignedView.vue";
import FlaggedView from "@/views/FlaggedView.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      component: DefaultLayout,
      children: [
        { path: "/", name: "Home", component: HomeView },
        { path: "/lists", name: "Lists", component: ListsView },
        { path: "/important", name: "Important", component: ImportantView },
        { path: "/planned", name: "Planned", component: PlannedView },
        { path: "/assigned", name: "Assigned", component: AssignedView },
        { path: "/flagged", name: "Flagged", component: FlaggedView },
      ],
    },
    {
      path: "/login",
      name: "Login",
      component: LoginView,
    },
    {
      path: "/register",
      name: "Register",
      component: RegisterView,
    },
    {
      path: "/forgetPassword",
      name: "ForgotPassword",
      component: ForgotPassword,
    },
    {
      path: "/:pathMatch(.*)*",
      name: "NotFound",
      component: NotFound,
    },
  ],
});

export default router;

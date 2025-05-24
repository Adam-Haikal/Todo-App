import { createRouter, createWebHistory } from "vue-router";
import DefaultLayout from "@/components/DefaultLayout.vue";
import GuestLayout from "@/components/GuestLayout.vue";
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
      meta: { requiresAuth: true },
      children: [
        { path: "/", name: "Home", component: HomeView },
<<<<<<< Updated upstream
        { path: "/lists", name: "Lists", component: ListsView },
=======
        { path: "/tasks", name: "Tasks", component: TasksView },
        { path: "/tasks/:id", name: "SubTasks", component: SubTasksView },
>>>>>>> Stashed changes
        { path: "/important", name: "Important", component: ImportantView },
        { path: "/planned", name: "Planned", component: PlannedView },
        { path: "/assigned", name: "Assigned", component: AssignedView },
        { path: "/flagged", name: "Flagged", component: FlaggedView },
      ],
    },
    {
      path: "/",
      component: GuestLayout,
      meta: { requiresGuest: true },
      children: [
        { path: "/login", name: "Login", component: LoginView },
        { path: "/register", name: "Register", component: RegisterView },
      ],
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

// router.beforeEach((to, from, next) => {
//   const userStore = useUserStore();
//   // Check if the route requires authentication
//   // and if the user is not logged in, redirect to login
//   if (
//     to.matched.some((record) => record.meta.requiresAuth) &&
//     !userStore.isLoggedIn
//   ) {
//     // userStore.isLoggedIn = false;
//     next({ name: "Login" });
//   }
//   // If the route requires guest access and the user is logged in, redirect to tasks
//   else if (
//     to.matched.some((record) => record.meta.requiresGuest) &&
//     userStore.isLoggedIn
//   ) {
//     // userStore.isLoggedIn = true;
//     next({ name: "Tasks" });
//   }
//   // Otherwise, proceed to the route
//   else next();
// });

export default router;

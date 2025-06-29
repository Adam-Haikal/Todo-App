import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/stores/user";
import DefaultLayout from "@/components/DefaultLayout.vue";
import GuestLayout from "@/components/GuestLayout.vue";

import ForgotPassword from "@/views/auth/ForgotPassword.vue";
import RegisterView from "@/views/auth/RegisterView.vue";
import LoginView from "@/views/auth/LoginView.vue";
import TasksView from "@/views/TasksView.vue";
import SubtasksView from "@/views/SubtasksView.vue";
import TagsView from "@/views/TagsView.vue";
import ImportantView from "@/views/ImportantView.vue";
import PlannedView from "@/views/PlannedView.vue";
import AssignedView from "@/views/AssignedView.vue";
import FlaggedView from "@/views/FlaggedView.vue";

import NotFound from "@/views/errors/NotFound.vue";
import ForbiddenView from "@/views/errors/ForbiddenView.vue";
import ServerError from "@/views/errors/ServerError.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      component: DefaultLayout,
      meta: { requiresAuth: true },
      children: [
        { path: "tasks", name: "Tasks", component: TasksView },
        { path: "subtasks/:id", name: "Subtasks", component: SubtasksView },
        { path: "tags", name: "Tags", component: TagsView },
        { path: "important", name: "Important", component: ImportantView },
        { path: "planned", name: "Planned", component: PlannedView },
        { path: "assigned", name: "Assigned", component: AssignedView },
        { path: "flagged", name: "Flagged", component: FlaggedView },
      ],
    },
    {
      path: "/",
      component: GuestLayout,
      meta: { requiresGuest: true },
      children: [
        { path: "login", name: "Login", component: LoginView },
        { path: "register", name: "Register", component: RegisterView },
      ],
    },

    {
      path: "/forgotpassword",
      name: "ForgotPassword",
      component: ForgotPassword,
    },
    {
      path: "/forbidden",
      name: "Forbidden",
      component: ForbiddenView,
    },
    {
      path: "/servererror",
      name: "ServerError",
      component: ServerError,
    },
    {
      path: "/:pathMatch(.*)*",
      name: "NotFound",
      component: NotFound,
    },
  ],
});

let userFetched = false;
router.beforeEach(async (to, from, next) => {
  const userStore = useUserStore();

  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);
  const requiresGuest = to.matched.some((record) => record.meta.requiresGuest);

  // Only fetch user if the route actually cares about auth
  if ((requiresAuth || requiresGuest) && !userStore.user && !userFetched) {
    userFetched = true;
    try {
      await userStore.fetchUser();
    } catch (error) {
      userStore.clearUser();
    }
  }

  const isAuthenticated = userStore.user;

  if (requiresAuth && !isAuthenticated) next({ name: "Login" });
  else if ((requiresGuest && isAuthenticated) || to.path === "/")
    next({ name: "Tasks" });
  else next();
});

export default router;

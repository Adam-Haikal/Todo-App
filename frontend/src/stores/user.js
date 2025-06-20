import { defineStore } from "pinia";
import axiosClient from "@/axios";
import router from "@/router";
import { useTaskStore } from "@/stores/task";
import { useSubtaskStore } from "@/stores/subtask";
import { useTagStore } from "@/stores/tag";

export const useUserStore = defineStore("user", {
  state: () => ({
    user: null,
    errors: {},
  }),

  getters: {
    hasErrors: (state) => {
      return Object.keys(state.errors).length > 0;
    },
  },

  actions: {
    clearUser() {
      this.user = null;

      useTaskStore().tasks = [];
      useSubtaskStore().subtasks = [];
      useTagStore().tags = [];
    },

    clearErrors() {
      this.errors = {};
    },

    async fetchUser() {
      try {
        const response = await axiosClient.get("/api/user");
        this.user = response.data;
      } catch (error) {
        if (error.response && error.response.status === 401) {
          this.clearUser();
        }
        // console.error("Error fetching user:", error);
      }
    },

    async login(formData) {
      await axiosClient.get("/sanctum/csrf-cookie");
      /* clear old errors */
      this.clearErrors();

      try {
        await axiosClient.post("/login", formData);
        await this.fetchUser();
        router.push({ name: "Tasks" });
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        }
      }
    },

    async register(formData) {
      await axiosClient.get("/sanctum/csrf-cookie");
      /* clear old errors */
      this.clearErrors();

      try {
        await axiosClient.post("/register", formData);
        await this.fetchUser();
        router.push({ name: "Tasks" });
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        }
      }
    },

    async logout() {
      try {
        await axiosClient.post("/logout");
        /* Clear user data from the store */
        this.clearUser();

        router.push({ name: "Login" });
      } catch (error) {
        console.error("Logout failed", error);
      }
    },
  },
});

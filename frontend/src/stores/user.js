import { defineStore } from "pinia";
import axiosClient from "@/axios";
import router from "@/router";

export const useUserStore = defineStore("user", {
  state: () => ({
    user: null,
    isLoggedIn: false,
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
      this.isLoggedIn = false;
    },

    clearErrors() {
      this.errors = {};
    },

    async fetchUser() {
      try {
        const response = await axiosClient.get("/api/user");
        this.user = response.data;
        this.isLoggedIn = true;
      } catch (error) {
        // console.error("Error fetching user:", error);
      }
    },

    async login(formData) {
      await axiosClient.get("/sanctum/csrf-cookie");
      this.clearErrors = {}; // clear old errors
      try {
        await axiosClient.post("/login", formData);
        this.isLoggedIn = true;
        router.push({ name: "Tasks" });
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors; // Laravel validation errors
        }
      }
    },

    async register(formData) {
      await axiosClient.get("/sanctum/csrf-cookie");
      this.clearErrors = {}; // clear old errors
      try {
        await axiosClient.post("/register", formData);
        this.isLoggedIn = true;
        router.push({ name: "Tasks" });
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors; // Laravel validation errors
        }
      }
    },

    async logout() {
      try {
        await axiosClient.post("/logout");
        this.clearUser(); // Clear user data from the store
        router.push({ name: "Login" }); // Redirect to login page
      } catch (error) {
        console.error("Logout failed", error);
      }
    },
  },
});

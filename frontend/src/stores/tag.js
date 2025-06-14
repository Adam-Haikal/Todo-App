import { defineStore } from "pinia";
import axiosClient from "@/axios";

export const useTagStore = defineStore("tag", {
  state: () => ({
    tags: [],
  }),
  getters: {},
  actions: {
    /* Fetch tags  */
    async getTags() {
      try {
        const response = await axiosClient.get("/api/tags");
        this.tags = response.data;
      } catch (error) {
        console.error("Error fetching tags:", error);
      }
    },
  },
});

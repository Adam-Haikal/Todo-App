import { defineStore } from "pinia";
import axiosClient from "@/axios";

import { useUserStore } from "@/stores/user";

export const useTagStore = defineStore("tag", {
  state: () => ({
    tags: [],
  }),
  getters: {
    /* Check if logged in user has any tags */
    hasTags: (state) => state.tags && state.tags.length > 0,
  },
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

    /* Create a new tag */
    async createTag(tag) {
      try {
        const userStore = useUserStore();

        const userId = userStore.user.id;
        const response = await axiosClient.post("/api/tags", {
          ...tag,
          user_id: userId,
        });

        /* Add the new tag to the top of the local state */
        this.tags.unshift({
          ...response.data.tag,
          original_name: response.data.tag.name,
        });
      } catch (error) {
        console.error("Error creating tag:", error);
      }
    },

    /* Delete a tag */
    async deleteTag(tagId) {
      try {
        await axiosClient.delete(`/api/tags/${tagId}`);
      } catch (error) {
        console.error("Error deleting tag:", error);
      }
    },
  },
});

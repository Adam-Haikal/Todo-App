import { defineStore } from "pinia";
import axiosClient from "@/axios";
import { useUserStore } from "@/stores/user";
import { useTaskStore } from "@/stores/task";
import { toastDeleted } from "@/composables/toastDeleted";
import { toastCreated } from "@/composables/toastCreated";

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
      if (this.tags.length) return; // Prevent refetch if already loaded
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

        toastCreated(tag.name);

        /* Reset tag.color to a default value */
        tag.color = "#ffffff";
      } catch (error) {
        console.error("Error creating tag:", error);
      }
    },

    /* Delete a tag */
    async deleteTag(tagId, tag = {}) {
      try {
        await axiosClient.delete(`/api/tags/${tagId}`);

        /* Remove the deleted tag from the local state */
        this.tags = this.tags.filter((tagData) => tagData.id !== tagId);

        toastDeleted(tag.name);
      } catch (error) {
        console.error("Error deleting tag:", error);
      }
    },

    async attachTagToTask(taskId, tagId) {
      try {
        const response = await axiosClient.post(`/api/tasks/${taskId}/tags`, {
          tag_id: tagId,
        });

        /* Find the task in  local state and update its tags */
        const taskStore = useTaskStore();
        const task = taskStore.tasks.find((task) => task.id === taskId);
        if (task) {
          task.tags = response.data.tags;
        }
      } catch (error) {
        console.error("Error attaching tag to task:", error);
      }
    },

    async removeTagFromTask(tagId, taskId) {
      try {
        const response = await axiosClient.delete(
          `/api/tasks/${taskId}/tags/${tagId}`
        );

        const taskStore = useTaskStore();
        const task = taskStore.tasks.find((task) => task.id === taskId);
        if (task) {
          task.tags = response.data.tags;
        }
      } catch (error) {
        console.error("Error removing tag from task:", error);
      }
    },
  },
});

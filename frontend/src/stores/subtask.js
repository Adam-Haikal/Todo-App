import { defineStore } from "pinia";
import axiosClient from "@/axios";
import { toastCreated } from "@/composables/toastCreated";
import { toastUpdated } from "@/composables/toastUpdated";
import { toastDeleted } from "../composables/toastDeleted";

export const useSubtaskStore = defineStore("subtask", {
  state: () => ({
    subtasks: [],
  }),

  getters: {
    /* Check if any task exists */
    hasSubtasks: (state) => state.subtasks && state.subtasks.length > 0,
    /* Get pending tasks */
    ongoingTasks: (state) => state.subtasks.filter((task) => !task.completed),
    /* Get completed tasks */
    completedTasks: (state) => state.subtasks.filter((task) => task.completed),
  },

  actions: {
    /* Fetch subtasks */
    async getSubtasks(taskId) {
      try {
        const response = await axiosClient.get(
          `/api/subtasks?task_id=${taskId}`
        );

        /* Map the response data to include the original_name for reset */
        this.subtasks = response.data.map((subtask) => ({
          ...subtask,
          original_name: subtask.name,
        }));
      } catch (error) {
        console.error("Error fetching subtasks:", error);
      }
    },

    /* Create subtask */
    async createSubtask(subtask) {
      try {
        const response = await axiosClient.post("/api/subtasks", subtask);

        /* Add the new subtask to the top of the local state */
        this.subtasks.unshift({
          ...response.data.subtask,
          original_name: response.data.subtask.name,
        });

        toastCreated(subtask.name);
      } catch (error) {
        console.error("Error creating subtask:", error);
      }
    },

    /* Update subtask */
    async updateSubtask(subtask) {
      try {
        await axiosClient.put(`/api/subtasks/${subtask.id}`, subtask);

        toastUpdated(subtask.name);
      } catch (error) {
        console.error("Error updating subtask:", error);
      }
    },

    /* Delete subtask */
    async deleteSubtask(subtask) {
      try {
        await axiosClient.delete(`/api/subtasks/${subtask.id}`);

        /* Remove the deleted subtask from the local state */
        this.subtasks = this.subtasks.filter(
          (subtaskData) => subtaskData.id !== subtask.id
        );

        toastDeleted(subtask.name);
      } catch (error) {
        console.error("Error deleting task:", error);
      }
    },

    /* Reset subtask name */
    resetSubtaskName(subtaskId) {
      const subtask = this.subtasks.find((subtask) => subtask.id === subtaskId);
      if (subtask) {
        subtask.name = subtask.original_name;
      }
    },

    /* Toggle subtask completion status */
    async toggleSubtaskCompletion(subtaskId) {
      const subtask = this.subtasks.find((subtask) => subtask.id === subtaskId);
      if (subtask) {
        // subtask.completed = !subtask.completed;
        try {
          await axiosClient.put(`/api/subtasks/${subtaskId}`, {
            name: subtask.name,
            completed: !subtask.completed,
          });
          // Re-fetch all subtasks for the current task to ensure state is in sync
          if (subtask.task_id) {
            await this.getSubtasks(subtask.task_id);
          }
        } catch (error) {
          subtask.completed = !subtask.completed; // revert if error
          console.error("Error toggling subtask completion:", error);
        }
      }
    },
  },
});

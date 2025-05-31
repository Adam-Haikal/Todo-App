import { defineStore } from "pinia";
import axiosClient from "@/axios";

export const useSubtaskStore = defineStore("subtask", {
  state: () => ({
    subtasks: [],
  }),

  getters: {
    /* Check if any task exists */
    hasSubtasks: (state) => state.subtasks && state.subtasks.length > 0,
    /* Get completed tasks */
    completedTasks: (state) => state.subtasks.filter((task) => task.completed),
    /* Get pending tasks */
    pendingTasks: (state) => state.subtasks.filter((task) => !task.completed),
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
    async createSubtask(task) {
      try {
        const response = await axiosClient.post("/api/subtasks", task);

        /* Add the new subtask to the top of the local state */
        this.subtasks.unshift({
          ...response.data.subtask,
          original_name: response.data.subtask.name,
        });
      } catch (error) {
        console.error("Error creating subtask:", error);
      }
    },

    /* Update subtask */
    async updateSubtask(subtask) {
      try {
        await axiosClient.put(`/api/subtasks/${subtask.id}`, subtask);
      } catch (error) {
        console.error("Error updating subtask:", error);
      }
    },

    /* Reset subtask name */
    resetSubtaskName(subtaskId) {
      const subtask = this.subtasks.find((subtask) => subtask.id === subtaskId);
      if (subtask) {
        subtask.name = subtask.original_name;
      }
    },

    /* Delete subtask */
    async deleteSubtask(subtaskId) {
      try {
        await axiosClient.delete(`/api/subtasks/${subtaskId}`);

        /* Remove the deleted subtask from the local state */
        this.subtasks = this.subtasks.filter(
          (subtask) => subtask.id !== subtaskId
        );
      } catch (error) {
        console.error("Error deleting task:", error);
      }
    },
  },
});

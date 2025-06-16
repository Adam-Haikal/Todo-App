import { defineStore } from "pinia";
import axiosClient from "@/axios";
import { useUserStore } from "@/stores/user";
import { toastCreated } from "@/composables/toastCreated";
import { toastUpdated } from "@/composables/toastUpdated";
import { toastDeleted } from "@/composables/toastDeleted";

export const useTaskStore = defineStore("task", {
  state: () => ({
    tasks: [],
  }),

  getters: {
    /* Check if any task exists */
    hasTasks: (state) => state.tasks && state.tasks.length > 0,
  },

  actions: {
    /* Fetch tasks  */
    async getTasks() {
      try {
        const response = await axiosClient.get("/api/tasks");

        /* Map the response data to include the original_name for reset */
        this.tasks = response.data.map((task) => ({
          ...task,
          original_name: task.name,
        }));
      } catch (error) {
        console.error("Error fetching tasks:", error);
      }
    },

    /* Create a new task */
    async createTask(task) {
      try {
        const userStore = useUserStore();

        /* Get the user ID from the user store */
        const userId = userStore.user.id;
        const response = await axiosClient.post("/api/tasks", {
          ...task,
          user_id: userId,
        });

        /* Add the new task to the top of the local state */
        this.tasks.unshift({
          ...response.data.task,
          original_name: response.data.task.name,
        });

        toastCreated(task.name);
      } catch (error) {
        console.error("Error creating task:", error);
      }
    },

    /* Update a task */
    async updateTask(task) {
      try {
        await axiosClient.put(`/api/tasks/${task.id}`, task);

        toastUpdated(task.name);
      } catch (error) {
        console.error("Error updating task:", error);
      }
    },

    /* Delete a task */
    async deleteTask(task) {
      try {
        await axiosClient.delete(`/api/tasks/${task.id}`);

        /* Remove the deleted task from the local state */
        this.tasks = this.tasks.filter((taskData) => taskData.id !== task.id);

        toastDeleted(task.name);
      } catch (error) {
        console.error("Error deleting task:", error);
      }
    },

    /* Get a specific task */
    async getTask(taskId) {
      try {
        const response = await axiosClient.get(`/api/tasks/${taskId}`);
        return response.data;
      } catch (error) {
        console.error("Error fetching task:", error);
      }
    },

    /* Reset the task name */
    resetTaskName(taskId) {
      const task = this.tasks.find((task) => task.id === taskId);
      if (task) {
        task.name = task.original_name;
      }
    },
  },
});

import { defineStore } from "pinia";
import axiosClient from "@/axios";
import router from "@/router";
import { useUserStore } from "@/stores/user";

export const useTaskStore = defineStore("task", {
  state: () => ({
    tasks: [],
  }),

  getters: {
    hasTasks: (state) => state.tasks && state.tasks.length > 0, // task exists
    // Get completed tasks
    completedTasks: (state) => state.tasks.filter((task) => task.completed),
    // Get pending tasks
    pendingTasks: (state) => state.tasks.filter((task) => !task.completed),
  },

  actions: {
    // Fetch tasks from the API
    async getTasks() {
      try {
        const response = await axiosClient.get("/api/tasks");
        this.tasks = response.data;
      } catch (error) {
        console.error("Error fetching tasks:", error);
      }
    },
    // create a new task
    async createTask(task) {
      try {
        const userStore = useUserStore();

        const userId = userStore.user.id; // Get the user ID from the user store
        const res = await axiosClient.post("/api/tasks", {
          ...task,
          user_id: userId,
        });
        // clear the input field
        task.task_name = "";

        this.getTasks();

        // Redirect to the subtasks view after creating a task
        // router.push({
        //   name: "Subtasks",
        //   params: { id: response.data.task.id },
        // });
      } catch (error) {
        console.error("Error creating task:", error);
      }
    },

    // update a task
    async updateTask(task) {
      try {
        await axiosClient.put(`/api/tasks/${task.id}`, task);
      } catch (error) {
        console.error("Error updating task:", error);
      }
    },

    // delete a task
    async deleteTask(id) {
      try {
        await axiosClient.delete(`/api/tasks/${id}`);
        this.tasks = this.tasks.filter((task) => task.id !== id); // Remove the deleted task from the local state

        // const index = this.tasks.findIndex((t) => t.id === id);
        // if (index !== -1) {
        //   this.tasks.splice(index, 1);
        // }
      } catch (error) {
        console.error("Error deleting task:", error);
      }
    },
  },
});

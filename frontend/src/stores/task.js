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

    completedTasks: (state) => state.tasks.filter((task) => task.completed), // Get completed tasks

    pendingTasks: (state) => state.tasks.filter((task) => !task.completed), // Get pending tasks
  },

  actions: {
    // Fetch tasks from the API
    async getTasks() {
      try {
        const response = await axiosClient.get("/api/tasks");

        // Map the response data to include the original_task_name for reset
        this.tasks = response.data.map((task) => ({
          ...task,
          original_task_name: task.task_name,
        }));
      } catch (error) {
        console.error("Error fetching tasks:", error);
      }
    },

    // create a new task
    async createTask(task) {
      try {
        const userStore = useUserStore();

        const userId = userStore.user.id; // Get the user ID from the user store
        const response = await axiosClient.post("/api/tasks", {
          ...task,
          user_id: userId,
        });

        // Add the new task to the top of the local state
        this.tasks.unshift({
          ...response.data.task,
          original_task_name: response.data.task.task_name,
        });

        // clear the input field and fetch the tasks
        task.task_name = "";

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

    // reset the task name
    resetTaskName(taskId) {
      const task = this.tasks.find((task) => task.id === taskId);
      if (task) {
        task.task_name = task.original_task_name;
      }
    },

    // delete a task
    async deleteTask(taskId) {
      try {
        await axiosClient.delete(`/api/tasks/${taskId}`);

        // Remove the deleted task from the local state
        this.tasks = this.tasks.filter((task) => task.id !== taskId);
      } catch (error) {
        console.error("Error deleting task:", error);
      }
    },
  },
});

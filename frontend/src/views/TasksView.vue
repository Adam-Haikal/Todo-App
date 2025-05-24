<script setup>
import { computed, onMounted, ref } from "vue";
import { RouterLink } from "vue-router";
import { useTaskStore } from "@/stores/task";
import CardItem from "@/components/CardItem.vue";
import Input from "@/components/Input.vue";
import { PlusIcon } from "@heroicons/vue/24/outline";

// Import the task store
const taskStore = useTaskStore();

// const tasks = computed(() => taskStore.tasks);
const taskData = ref({ task_name: "" });
// const tasks = [
//   {
//     id: "1",
//     task_name: "first",
//   },
//   {
//     id: "2",
//     task_name: "second",
//   },
// ];
const showCreateForm = ref(false); // Show/hide create form

onMounted(async () => {
  taskStore.getTasks();
});
</script>

<template>
  <div>
    <header class="bg-white shadow-sm">
      <div
        class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8 justify-between flex items-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Tasks</h1>

        <!-- Show fom button -->
        <button
          type="button"
          class="cursor-pointer"
          @click="showCreateForm = !showCreateForm">
          <PlusIcon
            class="h-8 p-1 w-8 bg-teal-400 text-white rounded-lg inline-flex stroke-2"
            aria-hidden="true" />
        </button>
      </div>
    </header>

    <div v-if="showCreateForm" class="mb-4 p-4 bg-gray-100 rounded-lg shadow">
      <form @submit.prevent="createNewTask" class="flex items-center">
        <Input
          inputType="text"
          v-model="taskData"
          class="border p-2 border-gray-300 rounded-lg !rounded-r-none"
          required />

        <!-- Submit form button -->
        <button
          type="submit"
          class="bg-teal-500 p-1 text-white text-xs rounded-l-none rounded-r-lg cursor-pointer">
          Add Task
        </button>

        <!-- Close form button -->
        <button
          type="button"
          @click="showCreateForm = false"
          class="ml-2 text-gray-500 cursor-pointer hover:text-red-400">
          Cancel
        </button>
      </form>
    </div>

    <!-- Display tasks -->
    <main>
      <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- <pre>{{ taskStore.tasks }}</pre> -->

        <RouterLink
          v-for="task in taskStore.tasks"
          :key="task.id"
          :to="{ name: 'SubTasks', params: { id: task.id } }"
          class="gap-1 grid">
          <CardItem :tasksItem="task" />
        </RouterLink>

        <p v-if="!taskStore.hasTasks">No tasks available.</p>

        <!-- Pagination links -->
      </section>
    </main>
  </div>
</template>

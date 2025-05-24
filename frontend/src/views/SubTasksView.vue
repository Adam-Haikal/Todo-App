<script setup>
import { useRoute } from "vue-router";
import { PlusIcon } from "@heroicons/vue/24/outline";
import Input from "@/components/Input.vue";
import { computed, onMounted, ref } from "vue";
import axiosClient from "@/axios";
import CardItem from "@/components/CardItem.vue";

const route = useRoute();

const hasTasks = computed(() => tasks.value && tasks.value.length > 0);
// Submit new subtask
const tasks = ref([]);
// Show/hide create form
const showCreateForm = ref(false);

const newTask = ref({
  subtask_name: "",
  completed: false,
  completed_at: null,
});

const taskId = route.params.id;

const submit = async () => {
  try {
    if (!newTask.value.subtask_name.trim()) {
      console.error("Task name is required");
      return;
    }
    const formData = new FormData();
    formData.append("task_id", taskId);
    formData.append("subtask_name", newTask.value.subtask_name);
    formData.append("completed", Number(newTask.value.completed));

    const response = await axiosClient.post(
      `/api/tasks/${taskId}`,
      formData
    );
    // Handle the response data
    tasks.value.push(response.data); // <--- Update the tasks array with the new subtask data
    showCreateForm.value = false;
  } catch (error) {
    console.error("Error creating task", error);
  }
};

onMounted(() => {
  try {
    axiosClient.get(`/api/tasks/${taskId}`).then((response) => {
      console.log(response.data);
      tasks.value = response.data;
    });
  } catch (error) {
    console.error("Error fetching tasks", error);
  }
});
</script>

<template>
  <div>
    <header class="bg-white shadow-sm">
      <div
        class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8 justify-between flex items-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          Sub Tasks
        </h1>
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
      <form @submit.prevent="submit" class="flex">
        <Input
          v-model="newTask.subtask_name"
          inputType="text"
          class="border p-2 mr-2"
          required />
        <Input
          v-model="newTask.completed"
          inputType="checkbox"
          class="border p-4 mr-2" />

        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded">
          Add Task
        </button>
        <button
          type="button"
          @click="showCreateForm = false"
          class="ml-2 text-gray-500">
          Cancel
        </button>
      </form>
    </div>

    <!-- Display subtasks -->
    <main>
      <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- :to="{ name: 'SubTasks', params: { id: task.id } }" -->
        <div v-for="subtask in tasks" :key="subtask.id" class="gap-1 grid">
          <CardItem subTask :tasksItem="subtask" />
        </div>
        <p v-if="!hasTasks">No tasks available.</p>

        <!-- Pagination links -->
      </section>
    </main>
  </div>
</template>

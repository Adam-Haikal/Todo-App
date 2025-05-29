<script setup>
import { ref } from "vue";
import { useTaskStore } from "@/stores/task";
import { PlusIcon } from "@heroicons/vue/24/outline";
import Input from "@/components/Input.vue";

const taskStore = useTaskStore();

const showForm = ref(false); // Show/hide create form
const taskData = ref({
  task_name: "",
});

defineProps({
  title: {
    type: String,
    default: "Tasks",
  },
  hasForm: {
    type: Boolean,
    default: false,
  },
});

// const handleCreateTask = async () => {
//   await taskStore.createTask({ ...taskData.value }); // send a copy
//   taskData.value = { task_name: "" }; // reset with a new object
//   showForm.value = false;
// };

// const emit = defineEmits(["update:modelValue"]);
// const emit = defineEmits(["newTaskCreated"]);
</script>

<template>
  <section>
    <header class="bg-white shadow-sm">
      <div
        class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8 justify-between flex items-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          {{ title }}
        </h1>

        <!-- Show fom button -->
        <button
          v-if="hasForm"
          type="button"
          class="cursor-pointer"
          @click="showForm = !showForm">
          <PlusIcon
            class="h-8 p-1 w-8 bg-teal-400 text-white rounded-lg inline-flex stroke-2"
            aria-hidden="true" />
        </button>
      </div>
    </header>

    <div v-if="showForm && hasForm" class="mb-4 p-4 rounded-lg shadow">
      <form
        @submit.prevent="
          taskStore.createTask(taskData);
          showForm = false;
        "
        class="flex space-x-2">
        <Input
          inputType="text"
          v-model="taskData.task_name"
          class="border-gray-300 rounded-lg"
          required />

        <!-- Submit form button -->
        <button
          type="submit"
          class="bg-teal-500 p-1 rounded-lg text-white text-xs cursor-pointer">
          Add Task
        </button>

        <!-- Close form button -->
        <button
          type="button"
          @click="showForm = false"
          class="text-gray-500 cursor-pointer hover:text-red-400">
          Cancel
        </button>
      </form>
    </div>
  </section>
</template>

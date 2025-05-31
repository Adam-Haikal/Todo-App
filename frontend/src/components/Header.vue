<script setup>
import { ref } from "vue";
import { useTaskStore } from "@/stores/task";
import { useSubtaskStore } from "@/stores/subtask";
import { PlusIcon } from "@heroicons/vue/24/outline";
import Input from "@/components/Input.vue";

const taskStore = useTaskStore();
const subtaskStore = useSubtaskStore();

/* Show/hide create form */
const showForm = ref(false);
const taskData = ref({});

const props = defineProps({
  title: {
    type: String,
    default: "Tasks",
  },
  hasForm: {
    type: Boolean,
    default: false,
  },
  isSubtask: {
    type: Boolean,
    default: false,
  },
  taskId: {
    type: String,
    required: false,
  },
});

const handleSubmit = async (formData) => {
  if (props.isSubtask) {
    await subtaskStore.createSubtask({
      name: formData.name,
      task_id: props.taskId,
      completed: formData.completed ?? false,
    });
  } else {
    await taskStore.createTask(formData);
  }
  taskData.value = {};
  showForm.value = false;
};

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
        @submit.prevent="handleSubmit(taskData)"
        class="flex items-center space-x-2 max-w-5xl mx-auto">
        <Input
          inputType="text"
          v-model="taskData.name"
          class="border-gray-300 rounded-lg w-full"
          required />

        <!-- input for completed checkbox -->
        <span v-if="isSubtask" class="size-10">
          <Input
            inputType="checkbox"
            v-model="taskData.completed"
            class="size-10" />
        </span>

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

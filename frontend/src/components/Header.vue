<script setup>
import { ref, watch } from "vue";
import { RouterLink } from "vue-router";
import { useTaskStore } from "@/stores/task";
import { useSubtaskStore } from "@/stores/subtask";
import { useTagStore } from "@/stores/tag";
import { useClickOutside } from "@/composables/useClickOutside";
import { PlusIcon, ChevronLeftIcon } from "@heroicons/vue/24/outline";
import { toast } from "vue3-toastify";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";

const taskStore = useTaskStore();
const subtaskStore = useSubtaskStore();
const tagStore = useTagStore();

const props = defineProps({
  title: {
    type: String,
    // default: "Tasks",
  },
  subtitle: {
    type: String,
    required: false,
  },
  hasForm: {
    type: Boolean,
    default: false,
  },
  dataType: {
    type: String,
    default: "task",
  },
  taskId: {
    type: String,
    required: false,
  },
});

const taskData = ref({
  color: "#ffffff",
});
/* Show/hide create form */
const showForm = ref(false);
const headerRef = ref(null);

/* Close form on click outside the card*/
useClickOutside(
  headerRef,
  () => {
    handleCancel();
  },
  showForm
);

const handleSubmit = async (formData) => {
  if (props.dataType === "subtask") {
    await subtaskStore.createSubtask({
      name: formData.name,
      task_id: props.taskId,
      completed: formData.completed ?? false,
    });
  } else if (props.dataType === "task") {
    await taskStore.createTask(formData);
  } else {
    await tagStore.createTag({
      name: formData.name,
      color: formData.color,
      task_id: props.taskId,
    });

    /* Reset taskData.color to a default value */
    taskData.value.color = "#ffffff";
  }

  /* Show create success message */
  toast.success(formData.name + " has been created successfully!", {
    position: "bottom-right",
    autoClose: 2000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: false,
    progress: undefined,
    theme: "colored",
  });
  handleCancel();
};

const handleCancel = () => {
  showForm.value = false;
  taskData.value = {
    color: "#ffffff",
  };
};

const isValidColor = (color) => {
  const regex = /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/;
  return regex.test(color);
};

watch(
  () => taskData.color,
  (newColor) => {
    if (!isValidColor(newColor)) {
      console.error("Invalid color format");
    }
  }
);
// const emit = defineEmits(["update:modelValue"]);
// const emit = defineEmits(["newTaskCreated"]);
</script>

<template>
  <section>
    <header class="bg-white shadow-sm">
      <div
        class="mx-auto px-4 py-3 sm:px-6 lg:px-8 justify-between flex items-center">
        <!-- Back button -->
        <RouterLink
          :to="dataType !== 'task' ? { name: 'Tasks' } : {}"
          class="inline-flex gap-2 group items-center">
          <ChevronLeftIcon
            v-if="dataType !== 'task'"
            class="bg-indigo-600 group-hover:bg-indigo-500 text-white size-8 rounded-md" />

          <h1
            class="text-3xl font-bold tracking-tight text-gray-900 group-hover:text-gray-700">
            {{ title }}
          </h1>
        </RouterLink>

        <!-- Show fom button -->
        <button
          v-if="hasForm"
          type="button"
          @click="showForm = !showForm"
          :disabled="showForm">
          <PlusIcon
            class="h-8 p-1 w-8 bg-teal-400 text-white rounded-lg inline-flex stroke-2 cursor-pointer"
            aria-hidden="true" />
        </button>
      </div>
    </header>

    <div
      v-if="showForm && hasForm"
      ref="headerRef"
      class="p-4 rounded-lg shadow">
      <form
        @submit.prevent="handleSubmit(taskData)"
        class="flex items-center space-x-2 max-w-5xl mx-auto">
        <Input
          inputType="text"
          v-model="taskData.name"
          class="border-gray-300 rounded-lg w-full"
          :placeholder="subtitle"
          required />

        <!-- input for completed checkbox -->
        <span v-if="dataType === 'subtask'" class="size-10">
          <Input
            inputType="checkbox"
            v-model="taskData.completed"
            class="size-10" />
        </span>

        <!-- input for tag color -->
        <div v-if="dataType === 'tag'">
          <input
            type="color"
            id="color"
            name="color"
            v-model="taskData.color"
            title="Choose your tag color"
            class="size-10" />
        </div>

        <!-- Submit form button -->
        <Button
          type="submit"
          class="bg-teal-500 p-2 rounded-lg text-white cursor-pointer text-sm">
          Create
        </Button>

        <!-- Close form button -->
        <Button
          type="button"
          @click="handleCancel()"
          class="text-gray-500 cursor-pointer hover:text-red-400 text-sm">
          Cancel
        </Button>
      </form>
    </div>
  </section>
</template>

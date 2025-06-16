<script setup>
import { ref, watch } from "vue";
import { RouterLink } from "vue-router";
import { useClickOutside } from "@/composables/useClickOutside";
import { PlusIcon, ChevronLeftIcon } from "@heroicons/vue/24/outline";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";

const props = defineProps({
  title: {
    type: String,
    // default: "Tasks",
  },
  subtitle: {
    type: String,
    required: false,
  },
  dataType: {
    type: String,
    default: "task",
  },
  handleSubmit: {
    type: Function,
    required: true,
  },
});

/* Show/hide create form */
const showForm = ref(false);
const headerRef = ref(null);
const taskData = ref({
  color: "#ffffff",
});

/* Close form on click outside the card*/
useClickOutside(
  headerRef,
  () => {
    /* Call handleCancel after form submission */
    handleCancel();
  },
  showForm
);

const handleCancel = () => {
  showForm.value = false;
  taskData.value = {
    color: "#ffffff",
  };
};

defineExpose({
  handleCancel,
});

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
          type="button"
          @click="showForm = !showForm"
          :disabled="showForm">
          <PlusIcon
            class="h-8 p-1 w-8 bg-teal-400 text-white rounded-lg inline-flex stroke-2 cursor-pointer"
            aria-hidden="true" />
        </button>
      </div>
    </header>

    <!-- Create form -->
    <div v-if="showForm" ref="headerRef" class="p-4 rounded-lg shadow">
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

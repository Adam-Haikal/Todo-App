<script setup>
import { defineProps, ref } from "vue";
import { useTaskStore } from "@/stores/task";
import { Disclosure, DisclosureButton, MenuItem } from "@headlessui/vue";
import { EllipsisVerticalIcon } from "@heroicons/vue/24/outline";
import DropdownMenu from "@/components/DropdownMenu.vue";
import Input from "@/components/Input.vue";

const taskStore = useTaskStore();

const props = defineProps({
  tasksItem: {
    type: Object,
    required: true,
  },
  isCompleted: {
    type: Boolean,
    default: false,
  },
  subTask: {
    type: Boolean,
    default: false,
  },
});

const showForm = ref(false); // Show/hide update form
const formattedDate = new Date(props.tasksItem.updated_at).toLocaleString(
  "en-GB",
  {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    hour12: true,
  }
);

const handleDelete = () => {
  console.log("delete");
};
</script>

<template>
  <div
    class="bg-white space-x-1 rounded-lg px-2 border-2 border-gray-200 hover:bg-white/30 flex items-center">
    <!-- Checkbox for completed status -->
    <button
      v-if="subTask"
      type="button"
      name="completedButton"
      id="completedButton"
      :class="[
        isCompleted
          ? 'bg-green-500 border-green-600'
          : 'bg-gray-100 border-gray-300',
        'h-5 w-5 rounded-full border-2 appearance-none',
      ]" />

    <!-- Task content -->
    <section class="w-full ml-2">
      <!-- Only display if it is task -->
      <div v-if="!subTask">
        <router-link
          v-show="tasksItem.id"
          :to="{ name: 'Subtasks', params: { id: tasksItem.id } }">
          <div class="py-2">
            <p
              class="text-md font-bold text-gray-300 dark:text-gray-900 group-hover:text-blue-500">
              {{ tasksItem.task_name }}
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-600 font-normal">
              Last updated: {{ formattedDate }}
            </p>
          </div>
        </router-link>
      </div>

      <!-- Only display subtask info if it exists -->
      <div v-if="subTask">
        <p
          class="text-md font-semibold text-gray-300 dark:text-gray-900 group-hover:text-blue-500">
          {{ tasksItem.subtask_name }}
        </p>
      </div>

      <div v-if="showForm" class="mr-2 mb-2">
        <form
          @submit.prevent="
            taskStore.updateTask(tasksItem);
            showForm = false;
          "
          class="flex space-x-2">
          <Input
            inputType="text"
            v-model="tasksItem.task_name"
            class="rounded-lg" />

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
    <!-- Edit section -->

    <!-- Dropdown menu button for Edit & Delete -->
    <DropdownMenu elapsed class="">
      <!-- Ellipsis Vertical Icon -->
      <template #menuIcon>
        <EllipsisVerticalIcon class="block size-6" aria-hidden="true" />
      </template>

      <!-- Dropdown menu items -->
      <template #default>
        <MenuItem v-slot="{ active }" @click="showForm = !showForm">
          <h2
            :class="[
              active ? 'bg-gray-100 outline-hidden' : '',
              'block px-4 py-2 text-sm text-gray-700 z-10 ',
            ]">
            Edit
          </h2>
        </MenuItem>

        <MenuItem v-slot="{ active }" @click="handleDelete">
          <h2
            :class="[
              active ? 'bg-gray-100 outline-hidden' : '',
              'block px-4 py-2 text-sm text-gray-700 border-t-2 border-gray-200',
            ]">
            Delete
          </h2>
        </MenuItem>
      </template>
    </DropdownMenu>
  </div>
</template>

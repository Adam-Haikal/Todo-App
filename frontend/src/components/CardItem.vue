<script setup>
import { Disclosure, DisclosureButton, MenuItem } from "@headlessui/vue";
import { EllipsisVerticalIcon } from "@heroicons/vue/24/outline";
import { defineProps, h } from "vue";
import DropdownMenu from "@/components/DropdownMenu.vue";

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

const handleEdit = () => {
  console.log("edit");
};
const handleDelete = () => {
  console.log("delete");
};
</script>

<template>
  <div
    class="bg-white h-15 rounded-lg p-4 border-2 border-gray-200 inline-flex items-center group gap-4 hover:bg-white/30 hover:cursor-pointer">
    <button
      v-if="subTask"
      type="button"
      name="completedButton"
      id="completedButton"
      :class="[
        isCompleted
          ? 'bg-green-500 border-green-600'
          : 'bg-gray-100 border-gray-300',
        'h-5 w-5 p-2 rounded-full border-2  appearance-none',
      ]" />

    <div class="w-full">
      <!-- Only display if it is task -->
      <div v-if="!subTask" class="space-y-1">
        <p
          class="text-md font-bold text-gray-300 dark:text-gray-900 group-hover:text-blue-500">
          {{ tasksItem.task_name }}
        </p>
        <p class="text-xs text-gray-500 dark:text-gray-600 font-normal">
          Last updated: {{ formattedDate }}
        </p>
      </div>

      <!-- Only display subtask info if it exists -->
      <div v-if="subTask">
        <p
          class="text-md font-semibold text-gray-300 dark:text-gray-900 group-hover:text-blue-500">
          {{ tasksItem.subtask_name }}
        </p>
      </div>
    </div>

    <!-- Dropdown menu button for Edit & Delete -->
    <DropdownMenu elapsed>
      <!-- Ellipsis Vertical Icon -->
      <template #menuIcon>
        <EllipsisVerticalIcon class="block size-6" aria-hidden="true" />
      </template>

      <!-- Dropdown menu items -->
      <template #default>
        <MenuItem v-slot="{ active }" @click="handleEdit">
          <h2
            :class="[
              active ? 'bg-gray-100 outline-hidden' : '',
              'block px-4 py-2 text-sm text-gray-700',
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

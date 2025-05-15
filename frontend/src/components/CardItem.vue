<script setup>
import { Disclosure, DisclosureButton, MenuItem } from "@headlessui/vue";
import {
  Bars3Icon,
  XMarkIcon,
  EllipsisVerticalIcon,
} from "@heroicons/vue/24/outline";
import { computed } from "vue";
import DropdownMenu from "@/components/DropdownMenu.vue";

defineProps({
  listItem: {
    type: Boolean,
    default: false,
  },
  isCompleted: {
    type: Boolean,
    default: false,
  },
});

const handleEdit = () => {
  console.log("edit");
};
const handleDelete = () => {
  console.log("delete");
};

const truncatedText = computed(() => {
  const text =
    "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sint libero iure at veniam deleniti, provident qui similique consequuntur obcaecati consectetur ab temporibus sit quo, vero impedit quisquam. Exercitationem, vitae animi!";
  return text.length > 50 ? text.slice(0, 50) + "..." : text;
});
</script>

<template>
  <div
    class="bg-white rounded-lg p-3 border-2 border-gray-200 inline-flex items-center group gap-4 hover:bg-white/30 hover:cursor-pointer">
    <button
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
      <p
        class="text-md font-bold text-gray-300 dark:text-gray-900 group-hover:text-blue-500">
        List Name (1)
      </p>
      <p
        class="text-sm font-medium italic text-gray-300 dark:text-gray-600 mt-2">
        {{ truncatedText }}
      </p>
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

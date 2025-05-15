<script setup>
import {
  Disclosure,
  DisclosureButton,
  Menu,
  MenuButton,
  MenuItems,
  MenuItem,
} from "@headlessui/vue";
import {
  Bars3Icon,
  XMarkIcon,
  EllipsisVerticalIcon,
} from "@heroicons/vue/24/outline";
import { computed } from "vue";

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

    <div class="hidden md:block">
      <div class="ml-4 flex items-center md:ml-6">
        <!-- Dropdown menu button for Edit & Delete -->
        <Menu as="div" class="relative ml-3">
          <div>
            <!-- Ellipsis Vertical Icon -->
            <MenuButton
              class="relative flex max-w-xs items-center rounded-full focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
              <span class="absolute -inset-1.5" />
              <EllipsisVerticalIcon class="block size-6" aria-hidden="true" />
            </MenuButton>
          </div>
          <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95">
            <!-- Dropdown menu items -->
            <MenuItems
              class="absolute right-0 z-10 mt-0 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden">
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
                    'block px-4 py-2 text-sm text-gray-700',
                  ]">
                  Delete
                </h2>
              </MenuItem>
            </MenuItems>
          </transition>
        </Menu>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useUserStore } from "@/stores/user";
import DropdownMenu from "@/components/DropdownMenu.vue";
import {
  Bars3Icon,
  XMarkIcon,
  ClipboardDocumentListIcon,
} from "@heroicons/vue/24/outline";
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  MenuItem,
} from "@headlessui/vue";

const userStore = useUserStore();

const navigation = [
  { name: "Tasks", to: { name: "Tasks" }, current: true },
  // { name: "Important", to: { name: "Important" }, current: false },
  // { name: "Planned", to: { name: "Planned" }, current: false },
  // { name: "Assigned", to: { name: "Assigned" }, current: false },
  // { name: "Flagged", to: { name: "Flagged" }, current: false },
];
const userNavigation = [
  { name: "Your Profile", to: { name: "Tasks" } },
  { name: "Tags", to: { name: "Tags" } },
  { name: "Logout", onClick: userStore.logout },
];
</script>

<template>
  <div class="min-h-full">
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
      <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <!-- Logo -->
            <div class="shrink-0">
              <ClipboardDocumentListIcon
                class="size-8 text-indigo-500"
                alt="TodoApp" />
            </div>

            <!-- Navigation links -->
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <RouterLink
                  v-for="item in navigation"
                  :key="item.name"
                  :to="item.to"
                  :class="[
                    $route.name === item.to.name
                      ? 'bg-gray-900 text-white'
                      : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                    'rounded-md px-3 py-2 text-sm font-medium',
                  ]"
                  :aria-current="
                    $route.name === item.to.name ? 'page' : undefined
                  ">
                  {{ item.name }}
                </RouterLink>
              </div>
            </div>
          </div>

          <!-- Dropdown menu button for userNavigation -->
          <DropdownMenu>
            <!-- User Icon -->
            <template #menuIcon>
              <span class="sr-only">Open user menu</span>
              <!-- <img class="size-8 rounded-full" :src="userStore.user.imageUrl" alt="" /> -->
              <span class="text-white ml-2">{{ userStore.user?.name }}</span>
            </template>

            <!-- Dropdown menu items -->
            <MenuItem
              v-for="item in userNavigation"
              :key="item.name"
              v-slot="{ active }">
              <template v-if="item.to">
                <RouterLink
                  :to="item.to"
                  :class="[
                    active ? 'bg-gray-100 outline-hidden' : '',
                    'block px-4 py-2 text-sm text-gray-700',
                  ]"
                  @click="item.onClick">
                  {{ item.name }}
                </RouterLink>
              </template>
              <template v-else>
                <div
                  :class="[
                    active ? 'bg-gray-100 outline-hidden' : '',
                    'block px-4 py-2 text-sm text-gray-700 cursor-pointer',
                  ]"
                  @click="item.onClick">
                  {{ item.name }}
                </div>
              </template>
            </MenuItem>
          </DropdownMenu>

          <!-- Mobile menu button (X)-->
          <div class="-mr-2 flex md:hidden">
            <DisclosureButton
              class="cursor-pointer relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
              <span class="absolute -inset-0.5" />
              <span class="sr-only">Open main menu</span>
              <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true" />
              <XMarkIcon v-else class="block size-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <!-- Navigation links for Mobile -->
      <DisclosurePanel class="md:hidden">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
          <RouterLink
            v-for="item in navigation"
            :key="item.name"
            :to="item.to"
            :class="[
              $route.name === item.to.name
                ? 'bg-gray-900 text-white'
                : 'text-gray-300 hover:bg-gray-700 hover:text-white',
              'block rounded-md px-3 py-2 text-base font-medium',
            ]"
            :aria-current="$route.name === item.to.name ? 'page' : undefined">
            {{ item.name }}
          </RouterLink>
        </div>

        <div class="border-t border-gray-700 pt-4 pb-3">
          <div class="flex items-center px-5">
            <div class="shrink-0">
              <!-- <img class="size-10 rounded-full" :src="userStore.user?.imageUrl" alt="" /> -->
            </div>
            <div class="ml-3">
              <div class="text-base/5 font-medium text-white">
                {{ userStore.user?.name }}
              </div>
              <div class="text-sm font-medium text-gray-400">
                {{ userStore.user?.email }}
              </div>
            </div>
          </div>

          <!-- Dropdown menu items for userNavigation for Mobile -->
          <div class="mt-3 space-y-1 px-2">
            <div v-for="item in userNavigation" :key="item.name">
              <RouterLink
                v-if="item.to"
                :to="item.to"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white"
                @click="item.onClick">
                {{ item.name }}
              </RouterLink>
              <div
                v-else
                type="button"
                class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white"
                @click="item.onClick">
                {{ item.name }}
              </div>
            </div>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>

    <!-- Main content -->
    <RouterView />
  </div>
</template>

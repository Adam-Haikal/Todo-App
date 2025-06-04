<script setup>
import { ref } from "vue";
import { useTaskStore } from "@/stores/task";
import { useSubtaskStore } from "@/stores/subtask";
import { EllipsisVerticalIcon } from "@heroicons/vue/24/outline";
import DropdownMenu from "@/components/DropdownMenu.vue";
import DropdownItem from "@/components/DropdownItem.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";

const taskStore = useTaskStore();
const subtaskStore = useSubtaskStore();

const props = defineProps({
  tasksItem: {
    type: Object,
    required: true,
  },
  isSubtask: {
    type: Boolean,
    default: false,
  },
});

/* Show/hide update form */
const showForm = ref(false);
const togglingSubtaskId = ref(null);
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

const handleToggle = async (subtaskId) => {
  togglingSubtaskId.value = subtaskId;
  await subtaskStore.toggleSubtaskCompletion(subtaskId);
  togglingSubtaskId.value = null;
};

const handleUpdate = async (taskItem) => {
  if (props.isSubtask) {
    await subtaskStore.updateSubtask(taskItem);
  } else {
    await taskStore.updateTask(taskItem);
  }
  showForm.value = false;
};

const handleCancel = (id) => {
  showForm.value = false;
  if (props.isSubtask) {
    subtaskStore.resetSubtaskName(id);
  } else {
    taskStore.resetTaskName(id);
  }
};

const handleDelete = async (id) => {
  if (props.isSubtask) {
    await subtaskStore.deleteSubtask(id);
  } else {
    await taskStore.deleteTask(id);
  }
};
</script>

<template>
  <div
    :class="[
      !isSubtask ? 'hover:bg-white/30' : '',
      'bg-white space-x-1 rounded-lg px-2 border-2 border-gray-200  flex items-center',
    ]">
    <!-- Checkbox for completed status -->
    <span :class="[!showForm ? 'inline-flex' : 'mb-14']">
      <button
        v-if="isSubtask"
        type="button"
        name="completedButton"
        id="completedButton"
        :disabled="togglingSubtaskId === tasksItem.id"
        @click="handleToggle(tasksItem.id)"
        :class="[
          tasksItem.completed
            ? 'bg-green-500 border-green-600'
            : 'bg-gray-100 border-gray-300',
          'h-5 w-5 rounded-full border-2 appearance-none hover:cursor-pointer',
        ]" />
    </span>

    <!-- Task content -->
    <section class="w-full ml-2">
      <div>
        <!-- Display normal text if not in edit mode, otherwise display form -->
        <template v-if="!showForm">
          <RouterLink
            @mousedown.prevent
            :class="[isSubtask ? 'font-semibold cursor-default' : 'font-bold']"
            :to="
              isSubtask
                ? {}
                : { name: 'Subtasks', params: { id: tasksItem.id } }
            ">
            <p
              name="taskName"
              class="py-2 text-md text-gray-300 dark:text-gray-900">
              {{ tasksItem.name }}
            </p>
          </RouterLink>
        </template>

        <template v-else>
          <div class="py-2 mr-4">
            <form @submit.prevent="handleUpdate(tasksItem)" class="">
              <Input
                inputType="text"
                v-model="tasksItem.name"
                class="rounded-lg" />

              <span class="flex mt-1 justify-end items-center space-x-2">
                <Button
                  type="submit"
                  class="bg-teal-500 p-2 rounded-lg text-white text-sm cursor-pointer">
                  Save
                </Button>
                <Button
                  type="button"
                  @click="handleCancel(tasksItem.id)"
                  class="text-gray-500 cursor-pointer hover:text-red-400 text-sm">
                  Cancel
                </Button>
              </span>
            </form>
          </div>
        </template>

        <p class="text-xs text-gray-500 dark:text-gray-600 font-normal mb-1">
          Last updated: {{ formattedDate }}
        </p>
      </div>
    </section>

    <!-- Dropdown menu button for Edit & Delete -->
    <DropdownMenu elapsed>
      <!-- Ellipsis Vertical Icon -->
      <template #menuIcon>
        <EllipsisVerticalIcon class="block size-6" aria-hidden="true" />
      </template>

      <!-- Dropdown menu items -->
      <template #default>
        <DropdownItem @click="showForm = !showForm">Edit</DropdownItem>

        <DropdownItem @click="handleDelete(tasksItem.id)">Delete</DropdownItem>
      </template>
    </DropdownMenu>
  </div>
</template>

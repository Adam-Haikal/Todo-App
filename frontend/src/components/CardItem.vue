<script setup>
import { computed, ref, h, onMounted } from "vue";
import { useTaskStore } from "@/stores/task";
import { useTagStore } from "@/stores/tag";
import { useSubtaskStore } from "@/stores/subtask";
import { useClickOutside } from "@/composables/useClickOutside";
import { colorContrast } from "@/composables/colorContrast";
import { EllipsisVerticalIcon, PlusIcon } from "@heroicons/vue/24/outline";
import DropdownMenu from "@/components/DropdownMenu.vue";
import DropdownItem from "@/components/DropdownItem.vue";
import TagItems from "@/components/TagItems.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

const taskStore = useTaskStore();
const tagStore = useTagStore();
const subtaskStore = useSubtaskStore();

dayjs.extend(relativeTime);

const props = defineProps({
  tasksItem: {
    type: Object,
    required: true,
  },
  isSubtask: {
    type: Boolean,
    default: false,
  },
  handleUpdate: {
    type: Function,
    required: true,
  },
  handleDelete: {
    type: Function,
    required: true,
  },
  handleRemoveTag: {
    type: Function,
    required: false,
  },
});

/* Show/hide update form */
const showForm = ref(false);
const showTagDropdown = ref(false);
const selectedTagId = ref(null);
const cardRef = ref(null);
const togglingSubtaskId = ref(null);

/* Close form on click outside the card*/
useClickOutside(
  cardRef,
  () => {
    handleCancel(props.tasksItem.id);
  },
  // showForm
  computed(() => showForm.value || showTagDropdown.value)
);

/* Ensure only one form is open at a time */
const openEditForm = () => {
  showForm.value = true;
  showTagDropdown.value = false;
};
const openTagDropdown = () => {
  showTagDropdown.value = true;
  showForm.value = false;
};

const handleToggle = async (subtaskId) => {
  togglingSubtaskId.value = subtaskId;
  await subtaskStore.toggleSubtaskCompletion(subtaskId);
  togglingSubtaskId.value = null;
};

const handleAddTag = async () => {
  if (!selectedTagId.value) return;

  /* Call the  backend to attach the tag to the task */
  await tagStore.attachTagToTask(props.tasksItem.id, selectedTagId.value);
  selectedTagId.value = null;
};

const handleCancel = (id) => {
  showForm.value = false;
  showTagDropdown.value = false;
  if (props.isSubtask) {
    subtaskStore.resetSubtaskName(id);
  } else {
    taskStore.resetTaskName(id);
  }
};

/**
 * If updated date is less than 7 days ago,
 * show relative time, otherwise show date
 */
const formattedDate = computed(() => {
  const date = props.tasksItem.updated_at;

  if (dayjs(date).isBefore(dayjs().subtract(7, "days"))) {
    return dayjs(date).format("DD MMM YYYY");
  } else {
    return dayjs(date).fromNow();
  }
});

const availableTags = computed(() => {
  const existingTagIds = (props.tasksItem.tags || []).map((tag) => tag.id);
  return tagStore.tags.filter((tag) => !existingTagIds.includes(tag.id));
});

onMounted(async () => {
  await tagStore.getTags();
});
</script>

<template>
  <div
    ref="cardRef"
    :class="[
      !isSubtask ? 'hover:bg-white/30' : '',
      'relative bg-white space-x-1 rounded-lg px-2 border-2 border-gray-200  flex items-center',
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
        <!------------------------ Form for adding tag ------------------------>
        <template v-if="showTagDropdown">
          <!-- Display tags -->
          <TagItems
            :tagItem="tasksItem"
            class="h-full"
            :handleRemoveTag="handleRemoveTag" />

          <div class="py-2 mr-4">
            <form @submit.prevent="handleAddTag">
              <p
                name="taskName"
                class="py-2 text-md font-bold text-gray-300 dark:text-gray-900">
                {{ tasksItem.name }}
              </p>
              <select
                v-model="selectedTagId"
                class="border rounded p-1"
                placeholder="Select a tag"
                name="tagSelect">
                <option disabled value="">Select a tag</option>
                <option
                  v-for="tag in availableTags"
                  :key="tag.id"
                  :value="tag.id">
                  {{ tag.name }}
                </option>
              </select>

              <div class="inline-flex mx-2 gap-2">
                <!-- Submit form button -->
                <Button
                  type="submit"
                  class="bg-teal-500 p-2 rounded-lg text-white cursor-pointer text-sm">
                  Add
                </Button>

                <!-- Close form button -->
                <Button
                  type="button"
                  @click="handleCancel()"
                  class="text-gray-500 cursor-pointer hover:text-red-400 text-sm">
                  Cancel
                </Button>
              </div>
            </form>
          </div>
        </template>

        <!------------------------ Form for updating task ------------------------>
        <template v-else-if="showForm">
          <div class="py-2 mr-4">
            <form
              @submit.prevent="
                handleUpdate(tasksItem);
                handleCancel(tasksItem.id);
              ">
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

        <!------------------------ Display normal text if not in edit/add mode, otherwise display form ------------------------>
        <template v-else>
          <div>
            <RouterLink
              @mousedown.prevent
              :class="[
                isSubtask ? 'font-semibold cursor-default' : 'font-bold',
                ' grid grid-cols-2',
              ]"
              :to="
                isSubtask
                  ? {}
                  : { name: 'Subtasks', params: { id: tasksItem.id } }
              ">
              <p
                name="taskName"
                :class="[
                  availableTags ? 'w-2/4 sm:w-3/4 inline-flex' : '',
                  'py-2 text-md text-gray-300 dark:text-gray-900',
                ]">
                {{ tasksItem.name }}
              </p>

              <!-- display the number of completed and uncompleted subtasks for each task -->
              <p
                v-if="!isSubtask && tasksItem.subtasks"
                class="py-2 text-md text-gray-300 dark:text-gray-900">
                {{
                  tasksItem.subtasks.filter((subtask) => subtask.completed)
                    .length
                }}/{{ tasksItem.subtasks.length }}
                <span class="font-normal">completed</span>
              </p>
              <p v-else>0/0 <span class="font-normal">completed</span></p>
            </RouterLink>

            <!-- Display tags -->
            <template v-if="tasksItem.tags">
              <TagItems
                :tagItem="tasksItem"
                class="h-14 absolute top-0"
                :handleRemoveTag="handleRemoveTag" />
            </template>
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
        <DropdownItem v-if="!isSubtask" @click="openTagDropdown">
          Add Tag
        </DropdownItem>

        <DropdownItem @click="openEditForm">Edit</DropdownItem>

        <DropdownItem @click="handleDelete(tasksItem)">Delete</DropdownItem>
      </template>
    </DropdownMenu>
  </div>
</template>

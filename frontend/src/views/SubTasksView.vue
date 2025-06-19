<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import { useSubtaskStore } from "@/stores/subtask";
import { useTaskStore } from "@/stores/task";
import Header from "@/components/Header.vue";
import CardItem from "@/components/CardItem.vue";
import ItemCount from "@/components/ItemCount.vue";
import { HalfCircleSpinner } from "epic-spinners";
import dayjs from "dayjs";

const route = useRoute();
const subtaskStore = useSubtaskStore();
const taskStore = useTaskStore();

const taskId = route.params.id;
const task = ref({});

const isLoading = ref(false);
const showOngoing = ref(true);
const showCompleted = ref(false);
const headerRef = ref(null);
const OngoingRef = ref([]);
const CompletedRef = ref([]);

const handleSubmit = async (formData) => {
  await subtaskStore.createSubtask({
    name: formData.name,
    task_id: taskId,
    completed: formData.completed ?? false,
  });
  /* Call handleCancel directly */
  headerRef.value.handleCancel();
};

const handleUpdate = async (formData, index) => {
  formData.original_name = formData.name;
  formData.updated_at = dayjs().toISOString();

  await subtaskStore.updateSubtask(formData);
  /* Call handleCancel directly */
  if (OngoingRef.value[index]) {
    OngoingRef.value[index].handleCancel(formData.id);
  }
  if (CompletedRef.value[index]) {
    CompletedRef.value[index].handleCancel(formData.id);
  }
};

const handleDelete = async (taskItem) => {
  await subtaskStore.deleteSubtask(taskItem);
};

onMounted(async () => {
  isLoading.value = true;
  subtaskStore.subtasks = [];
  try {
    /* Get task name from parent task */
    task.value = await taskStore.getTask(taskId);
    /* Fetch parent task details */
    await subtaskStore.getSubtasks(taskId);
  } catch (error) {
    console.error("Error fetching subtasks:", error);
  }
  isLoading.value = false;
});
</script>

<template>
  <!-- Listen to isToggling in CardItem and change cursor to wait-->
  <div>
    <Header
      :title="task.name"
      dataType="subtask"
      subtitle="Enter subtask name"
      :handleSubmit="handleSubmit"
      ref="headerRef" />

    <main>
      <div class="relative mx-auto sm:max-w-9/10 px-4 py-6 sm:px-6 lg:px-8">
        <div v-if="subtaskStore.hasSubtasks" class="space-y-6">
          <!-- Display ongoing subtasks -->
          <section>
            <span
              class="mb-1 cursor-pointer hover:text-gray-700 hover:underline"
              @click="showOngoing = !showOngoing">
              Ongoing subtasks
              <ItemCount>{{ subtaskStore.ongoingTasks.length }}</ItemCount>
            </span>
            <div id="ongoingContainer" v-if="showOngoing">
              <CardItem
                id="ongoingSubtasks"
                v-for="(subtask, index) in subtaskStore.ongoingTasks"
                :key="subtask.id"
                :tasksItem="subtask"
                :handleUpdate="(formData) => handleUpdate(formData, index)"
                :handleDelete="handleDelete"
                isSubtask
                ref="OngoingRef" />
            </div>
          </section>

          <!-- Display completed subtasks -->
          <section>
            <span
              class="mb-1 cursor-pointer hover:text-gray-700 hover:underline"
              @click="showCompleted = !showCompleted">
              Completed subtasks
              <ItemCount>{{ subtaskStore.completedTasks.length }}</ItemCount>
            </span>
            <div id="completedContainer" v-if="showCompleted">
              <CardItem
                id="completedSubtasks"
                v-for="(subtask, index) in subtaskStore.completedTasks"
                :key="subtask.id"
                :tasksItem="subtask"
                :handleUpdate="(formData) => handleUpdate(formData, index)"
                :handleDelete="handleDelete"
                isSubtask
                ref="CompletedRef" />
            </div>
          </section>
        </div>

        <!-- Display no subtasks message -->
        <div
          class="absolute top-[250px] left-1/2 transform -translate-x-1/2 -translate-y-1/2 -z-10">
          <HalfCircleSpinner
            v-if="isLoading"
            :animation-duration="1000"
            :size="60"
            :color="'#1e2939'" />
          <p v-if="!subtaskStore.hasSubtasks && !isLoading">
            No subtasks available.
          </p>
        </div>
      </div>
    </main>
  </div>
</template>

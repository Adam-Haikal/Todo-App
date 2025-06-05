<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import axiosClient from "@/axios";
import { useSubtaskStore } from "@/stores/subtask";
import Header from "@/components/Header.vue";
import CardItem from "@/components/CardItem.vue";
import ItemCount from "@/components/ItemCount.vue";
import { HalfCircleSpinner } from "epic-spinners";

const route = useRoute();
const subtaskStore = useSubtaskStore();

const taskId = route.params.id;
const task = ref({});
const isLoading = ref(false);
const showOngoing = ref(true);
const showCompleted = ref(false);

onMounted(async () => {
  isLoading.value = true;
  subtaskStore.subtasks = [];
  try {
    /* Fetch parent task details */
    const response = await axiosClient.get(`/api/tasks/${taskId}`);
    task.value = response.data;

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
    <Header :title="task.name" :taskId="taskId" hasForm isSubtask />

    <main>
      <div class="mx-auto sm:max-w-9/10 px-4 py-6 sm:px-6 lg:px-8">
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
                v-for="subtask in subtaskStore.ongoingTasks"
                :key="subtask.id"
                :tasksItem="subtask"
                isSubtask
                class="" />
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
                v-for="subtask in subtaskStore.completedTasks"
                :key="subtask.id"
                :tasksItem="subtask"
                isSubtask
                class="" />
            </div>
          </section>
        </div>

        <!-- Display no subtasks message -->
        <div
          class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
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

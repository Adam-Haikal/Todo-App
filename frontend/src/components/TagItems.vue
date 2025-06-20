<script setup>
import { colorContrast } from "@/composables/colorContrast";

const props = defineProps({
  tagItem: {
    type: Object,
    required: true,
  },
  pillClass: {
    type: String,
    default: "text-xs",
  },
  handleRemoveTag: {
    type: Function,
    required: false,
  },
});
</script>

<template>
  <div
    v-if="tagItem.tags && tagItem.tags.length > 0"
    class="absolute right-10 overflow-y-scroll w-2/4 sm:w-1/4 inline-flex">
    <div>
      <span
        v-for="tag in tagItem.tags"
        :key="tag.id"
        :class="[
          `px-2 py-1 rounded-full inline-flex m-0.5 shadow-md ` + pillClass,
        ]"
        :style="{
          backgroundColor: tag.color,
          color: colorContrast(tag.color),
        }">
        {{ tag.name }}

        <span
          @click="handleRemoveTag(tag.id, tagItem.id)"
          class="cursor-pointer ml-1">
          X
        </span>
      </span>
    </div>
  </div>
</template>

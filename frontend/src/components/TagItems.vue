<script setup>
import { colorContrast } from "@/composables/colorContrast";

const props = defineProps({
  tagItem: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div
    v-if="tagItem.tags.length > 0"
    class="absolute right-10 overflow-y-scroll w-2/4 sm:w-1/4 inline-flex">
    <div>
      <span
        v-for="tag in tagItem.tags"
        :key="tag.id"
        class="px-2 py-1 rounded-full text-xs inline-flex m-0.5"
        :style="{
          backgroundColor: tag.color,
          color: colorContrast(tag.color),
        }">
        {{ tag.name }}
      </span>
    </div>
  </div>
</template>

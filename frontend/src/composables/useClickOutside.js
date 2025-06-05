import { onMounted, onBeforeUnmount } from "vue";

export function useClickOutside(elementRef, callback, enabledRef) {
  const handler = (event) => {
    if (
      (!enabledRef || enabledRef.value) /* Only if enabled (form is open) */ &&
      elementRef.value /* Only if element is mounted */ &&
      !elementRef.value.contains(event.target) /* Click was outside element */
    ) {
      callback();
    }
  };

  onMounted(() => {
    document.addEventListener("mousedown", handler);
  });

  onBeforeUnmount(() => {
    document.removeEventListener("mousedown", handler);
  });
}

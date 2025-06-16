import { h } from "vue";
import { toast } from "vue3-toastify";
import { TrashIcon } from "@heroicons/vue/24/outline";

export function toastDeleted(itemName) {
  return new Promise((resolve) => {
    /* Show delete success message */
    toast.error(itemName + " has been deleted!", {
      icon: h(TrashIcon),
      position: "bottom-right",
      autoClose: 2000,
      pauseOnHover: false,
      theme: "colored",
    });
    resolve();
  });
}

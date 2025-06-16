import { toast } from "vue3-toastify";

export function toastUpdated(itemName) {
  /* Show update success message */
  toast.info(itemName + " has been updated!", {
    position: "bottom-right",
    autoClose: 2000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: false,
    progress: undefined,
    theme: "colored",
  });
}

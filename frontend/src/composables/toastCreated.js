import { toast } from "vue3-toastify";

export function toastCreated(itemName) {
  /* Show create success message */
  toast.success(itemName + " has been created successfully!", {
    position: "bottom-right",
    autoClose: 2000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: false,
    progress: undefined,
    theme: "colored",
  });
}

import { toast } from "vue3-toastify";

export function toastCreated(formData) {
  /* Show create success message */
  toast.success(formData.name + " has been created successfully!", {
    position: "bottom-right",
    autoClose: 2000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: false,
    progress: undefined,
    theme: "colored",
  });
}

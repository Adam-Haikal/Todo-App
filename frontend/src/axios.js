import axios from "axios";
import router from "@/router";
import { useUserStore } from "@/stores/user";

const axiosClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
  /* Implement token based API key authentication */
  withCredentials: true,
  withXSRFToken: true,
});

/* Add response interceptor */
axiosClient.interceptors.response.use(
  (response) => {
    return response;
  },
  async (error) => {
    const userStore = useUserStore();
    switch (error.response && error.response.status) {
      case 401:
        // Handle authentication errors
        userStore.clearUser();
        router.push({ name: "Login" });
        break;
      case 404:
        // Handle not found errors
        router.push({ name: "NotFound" });
        break;
      case 419:
        // Handle CSRF token errors
        userStore.clearUser();
        router.push({ name: "Login" });
        break;
      case 500:
        // Handle internal server errors
        // router.push({ name: "InternalServerError" });
        console.error("Internal Server Error:", error.response.data);
        break;
      default:
        // Handle other errors
        error.message = "An unexpected error occurred.";
    }
    return Promise.reject(error);
  }
);

export default axiosClient;

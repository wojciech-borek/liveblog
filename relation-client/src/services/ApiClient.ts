import axios, {AxiosInstance} from "axios";

export interface ApiResponse<T> {
    data: T;
    message?: string;
    status?: string;
}

const ApiClient: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_APP_API_URL,
    headers: {
        "Content-Type": "application/json",
    },
});

export default ApiClient;

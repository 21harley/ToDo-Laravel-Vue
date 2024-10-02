import axios from 'axios';
import store from '@/store';

// Crear una instancia de Axios con la baseURL configurada
const apiClient = axios.create({
  baseURL:'http://127.0.0.1:8000',  // Cambia esto por tu base URL
  headers: {
    'Content-Type': 'application/json',
  },
});

// Agregar el interceptor de solicitud
apiClient.interceptors.request.use((config) => {
  const token = store.state.token;
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, (error) => {
  return Promise.reject(error);
});

export default apiClient;
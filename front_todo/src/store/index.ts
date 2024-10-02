// src/store/index.ts
import { createStore } from 'vuex';
import apiClient from './../axios';  // Importa tu apiClient en lugar de axios
import User from './../type/user';

export default createStore({
  state: {
    token: localStorage.getItem('token') || '',
    user: null as User | null,
    error: { message: '', status:false },
  },
  mutations: {
    setToken(state, token) {
      state.token = token;
      localStorage.setItem('token', token);
    },
    setUser(state, user) {
      state.user = user;
      localStorage.setItem('user', JSON.stringify(user));
    },
    logout(state) {
      state.token = '';
      state.user = null;
      localStorage.removeItem('token');
    },
    setError(state, error) {
      state.error = error;
    }
  },
  actions: {
    async login({ commit }, credentials) {
      try {
        const response = await apiClient.post('/api/login', credentials);
        commit('setToken', response.data.token);
        commit('setUser', response.data.user);
        commit('setError', { message: '', error:false });
        return response;
      } catch (error) {
        console.error('Error during login:', error);
        commit('setError', { message: 'Invalid credentials', status:true });
      }
    },
    async fetchUser({ commit }) {
      try {
        const response = await apiClient.get('/api/');  // Ya no necesitas pasar el token manualmente, se añade con el interceptor
        commit('setUser', response.data);
      } catch (error) {
        console.error('Error fetching user:', error);
        commit('setError', { message: 'Invalid credentials', status:true });
      }
    },
    async register({commit},credentials){
      try {
        const response = await apiClient.post('/api/register', credentials);
        commit('setToken', response.data.token);
        commit('setUser', response.data.user);
        commit('setError', { message: '', error:false });
        return response;
      } catch (error) {
        console.error('Error during register:', error);
        commit('setError', { message: 'Invalid credentials', status:true });
      }
    },

  },
  getters: {
    isAuthenticated: (state) => !!state.token,
    getUser: (state) => state.user,
    getError: (state) => state.error
  },
});
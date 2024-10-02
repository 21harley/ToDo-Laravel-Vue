<template>
  <div class="login-container">
    <form @submit.prevent="login" class="login-form">
      <input v-model="email" type="email" placeholder="Email" class="input-field" />
      <input v-model="password" type="password" placeholder="Password" class="input-field" />
      <button type="submit" class="btn-submit">Login</button>

      <router-link to="/register" class="register-link">Register</router-link>
      <span v-if="banError" class="error-message">Error</span>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const store = useStore();
const router = useRouter();
const banError = ref(false);

const login = async () => {
  await store.dispatch('login', { email: email.value, password: password.value });

  if (store.getters.getError.status) {
    banError.value = true;
  } else {
    banError.value = false;
    router.push('/dashboard');
  }
};
</script>

<style lang="scss" scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f0f0f0;
}

.login-form {
  display: flex;
  flex-direction: column;
  padding: 2rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.input-field {
  margin-bottom: 1rem;
  padding: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
}

.btn-submit {
  background-color: #4caf50;
  color: white;
  padding: 0.75rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s;

  &:hover {
    background-color: #45a049;
  }
}

.register-link {
  margin-top: 1rem;
  text-align: center;
  color: #007bff;
  text-decoration: none;

  &:hover {
    text-decoration: underline;
  }
}

.error-message {
  color: red;
  text-align: center;
  margin-top: 1rem;
}
</style>

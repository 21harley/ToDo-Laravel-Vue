<template>
    <div class="create-note-container">
      <h1>Crear Nota</h1>
      <form @submit.prevent="createNote">
        <div>
          <label for="title">Título:</label>
          <input v-model="note.title" id="title" required />
        </div>
        <div>
          <label for="description">Descripción:</label>
          <textarea v-model="note.description" id="description" required></textarea>
        </div>
        <div>
          <label for="creation_date">Fecha de Creación:</label>
          <input type="date" v-model="note.creation_date" id="creation_date" required />
        </div>
        <div>
          <label for="due_date">Fecha de Vencimiento:</label>
          <input type="date" v-model="note.due_date" id="due_date" required />
        </div>
        <div>
          <label for="tags">Etiquetas:</label>
          <input v-model="note.tags" id="tags" placeholder="tag1,tag2" />
        </div>
        <div>
          <label for="image">Imagen URL:</label>
          <input v-model="note.image" id="image" />
        </div>
        <button type="submit">Crear Nota</button>
      </form>
      <router-link to="/dashboard">Volver al Panel de Control</router-link>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  import apiClient from './../axios';
  import { useRouter } from 'vue-router';
  import store from '@/store';

  const router = useRouter();
  const user = store.state.user;
  console.log(user)
  if (!user) {
    let aux = JSON.parse(localStorage.getItem('user') || '{}');
    if (aux) {
      store.commit('setUser', aux);
    }else{
      router.push('/');
    }
 }

  const note = ref({
    title: '',
    description: '',
    creation_date: new Date().toISOString().split('T')[0], // Fecha actual por defecto
    due_date: '',
    user_id: user?.id, // Cambiar según el ID del usuario autenticado
    tags: '',
    image: '',
  });
  


  const createNote = async () => {
    try {
       await apiClient.post('/api/notes',  {
        ...note.value,
        user_id: user?.id, // Cambiar según el ID del usuario autenticado
      });
      router.push('/dashboard'); // Redirigir al panel de control después de crear la nota
    } catch (error) {
      console.error('Error creando la nota:', error);
    }
  };
  </script>
  
  <style lang="scss">
  .create-note-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  
    h1 {
      text-align: center;
      color: #4caf50; // Color verde
    }
  
    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
  
      label {
        font-weight: bold;
        color: #333;
      }
  
      input, textarea {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        &:focus {
          border-color: #4caf50; // Color verde en focus
          outline: none;
        }
      }
  
      button {
        background-color: #4caf50; // Color verde
        color: white;
        border: none;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        &:hover {
          background-color: #45a049; // Color verde oscuro en hover
        }
      }
    }
  
    a {
      margin-top: 20px;
      text-align: center;
      display: block;
      color: #4caf50; // Color verde
      text-decoration: none;
    }
  }
  </style>
  
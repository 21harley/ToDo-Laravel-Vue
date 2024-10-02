<template>
    <div class="edit-note-container">
      <h1>Editar Nota</h1>
      <form @submit.prevent="updateNote">
        <div class="form-group">
          <label for="title">Título:</label>
          <input v-model="note.title" type="text" id="title" placeholder="Título de la nota" required />
        </div>
        <div class="form-group">
          <label for="description">Descripción:</label>
          <textarea v-model="note.description" id="description" placeholder="Descripción de la nota" required></textarea>
        </div>
        <div class="form-group">
          <label for="creation_date">Fecha de Creación:</label>
          <input v-model="note.creation_date" type="date" id="creation_date" required />
        </div>
        <div class="form-group">
          <label for="due_date">Fecha de Vencimiento:</label>
          <input v-model="note.due_date" type="date" id="due_date" required />
        </div>
        <div class="form-group">
          <label for="tags">Etiquetas:</label>
          <input v-model="note.tags" type="text" id="tags" placeholder="Etiquetas (separadas por comas)" />
        </div>
        <button type="submit">Actualizar Nota</button>
        <router-link to="/dashboard" class="cancel-button">Cancelar</router-link>
      </form>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import apiClient from './../axios';
  import Note from './../type/note';
  import store from '@/store';

  const route = useRoute();
  const router = useRouter();
  const note = ref<Note>({
    id: 0,
    user_id: 0,
    title: '',
    description: '',
    creation_date: '',
    due_date: '',
    tags: '',
    image: ''
  });
  

  let aux = JSON.parse(localStorage.getItem('user') || '{}');
  if (!aux) {
    router.push('/');
  }


  // Fetch the note data by ID
  const fetchNote = async () => {
    const noteId = route.params.id; // Assuming the route has a parameter named 'id'
    try {
      const response = await  apiClient.get(`/api/notes/${noteId}`);
      note.value = response.data.note;
    } catch (error) {
      console.error('Error fetching note:', error);
    }
  };
  
  const updateNote = async () => {
    const noteId = route.params.id; // Get the ID from the route parameters
    try {
      await apiClient.put(`/api/notes/${noteId}`, note.value);
      router.push('/dashboard'); // Redirect to the notes page after update
    } catch (error) {
      console.error('Error updating note:', error);
    }
  };
  
  onMounted(fetchNote);
  </script>
  
  <style lang="scss">
  .edit-note-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    
    h1 {
      text-align: center;
      color: #4caf50; // Color verde
      margin-bottom: 20px;
    }
  
    form {
      display: flex;
      flex-direction: column;
  
      .form-group {
        margin-bottom: 15px;
  
        label {
          display: block;
          margin-bottom: 5px;
          color: #333;
        }
  
        input,
        textarea {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 4px;
        }
  
        textarea {
          resize: vertical;
          min-height: 100px;
        }
      }
  
      button {
        background-color: #4caf50; // Color verde
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
  
        &:hover {
          background-color: #45a049; // Un poco más oscuro al pasar el ratón
        }
      }
  
      .cancel-button {
        display: block;
        text-align: center;
        margin-top: 10px;
        color: #f44336; // Color rojo
        text-decoration: underline;
      }
    }
  }
  </style>
  
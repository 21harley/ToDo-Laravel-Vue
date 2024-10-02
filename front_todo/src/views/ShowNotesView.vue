<template>
    <div class="show-notes-container">
      <h1>Mis Notas</h1>
      <div class="notes-grid">
        <div class="note-card" v-for="note in notes" :key="note.id">
          <h2>{{ note.title }}</h2>
          <p>{{ note.description }}</p>
          <p><strong>Fecha de Creación:</strong> {{ formatDate(note.creation_date) }}</p>
          <p><strong>Fecha de Vencimiento:</strong> {{ formatDate(note.due_date) }}</p>
          <div class="tags">
            <span  class="tag">{{ note.tags }}</span>
          </div>
          <div class="note-actions">
            <router-link :to="`/edit-note/${note.id}`" class="edit-button">Editar</router-link>
            <button @click="deleteNote(note.id)" class="delete-button">Eliminar</button>
          </div>
        </div>
      </div>
      <router-link to="/dashboard" class="add-note-button"> Panel Principal</router-link>
      <router-link to="/create-note" class="add-note-button">Agregar Nota</router-link>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  import Nota from './../type/note';
  import apiClient from '@/axios';

  const notes = ref<Nota[]>([]);
  const router = useRouter();
  
  const fetchNotes = async () => {
    try {
      const response = await apiClient.get('/api/notes');
      notes.value = response.data.notes;
    } catch (error) {
      console.error('Error fetching notes:', error);
    }
  };
  
  const deleteNote = async (id: number) => {
    try {
      await apiClient.delete(`/api/notes/${id}`);
      notes.value = notes.value.filter(note => note.id !== id); // Actualiza la lista de notas después de eliminar
    } catch (error) {
      console.error('Error deleting note:', error);
    }
  };
  
  const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString(); // Formato de fecha local
  };
  
  onMounted(fetchNotes);
  </script>
  
  <style lang="scss">
  .show-notes-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    
    h1 {
      text-align: center;
      color: #4caf50; // Color verde
      margin-bottom: 20px;
    }
  
    .notes-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
  
      .note-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
  
        &:hover {
          transform: translateY(-5px);
        }
  
        h2 {
          margin-top: 0;
          color: #333;
        }
  
        .tags {
          margin: 10px 0;
  
          .tag {
            display: inline-block;
            background-color: #e0f7fa; // Color suave
            color: #00796b; // Color verde oscuro
            padding: 5px 10px;
            border-radius: 4px;
            margin-right: 5px;
            font-size: 0.9em;
          }
        }
  
        .note-actions {
          display: flex;
          justify-content: space-between;
          margin-top: 10px;
  
          .edit-button {
            background-color: #4caf50; // Color verde
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
          }
  
          .delete-button {
            background-color: #f44336; // Color rojo
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
          }
        }
      }
    }
  
    .add-note-button {
      display: block;
      margin: 20px auto;
      padding: 10px 20px;
      background-color: #4caf50; // Color verde
      color: white;
      border-radius: 4px;
      text-decoration: none;
      text-align: center;
    }
  }
  </style>
  
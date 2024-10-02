<template>
    <div class="home-container">
      <header class="header">
        <h1 class="title">Gestor de Notas y Tareas</h1>
        <p class="subtitle">Organiza tus notas y tareas de forma eficiente</p>
      </header>
  
      <section class="notes-section">
        <h2 class="section-title">Tus Notas</h2>
        <div class="notes-list">
          <div class="note-card" v-for="note in notes" :key="note.id">
            <h3 class="note-title">{{ note.title }}</h3>
            <p class="note-description">{{ note.description }}</p>
          </div>
        </div>
        <router-link to="/register" class="add-note-button">Registrarse</router-link>
      </section>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  
  // Lista de notas de ejemplo (esto vendría de la API o store)
  const notes = ref([
    { id: 1, title: 'Nota 1', description: 'Descripción de la nota 1' },
    { id: 2, title: 'Nota 2', description: 'Descripción de la nota 2' },
  ]);
  
  </script>
  
  <style scoped lang="scss">
  .home-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #f0f0f0;
    padding: 2rem;
    min-height: 100vh;
  }
  
  .header {
    text-align: center;
    margin-bottom: 2rem;
  
    .title {
      font-size: 2.5rem;
      color: #4caf50;
    }
  
    .subtitle {
      font-size: 1.2rem;
      color: #333;
    }
  }
  
  .notes-section {
    width: 100%;
    max-width: 800px;
    background-color: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  
    .section-title {
      font-size: 1.8rem;
      color: #4caf50;
      margin-bottom: 1rem;
      text-align: center;
    }
  
    .notes-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 1.5rem;
  
      .note-card {
        background-color: #e6f5e1;
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  
        .note-title {
          font-size: 1.2rem;
          color: #333;
          margin-bottom: 0.5rem;
        }
  
        .note-description {
          font-size: 1rem;
          color: #666;
        }
      }
    }
  
    .add-note-button {
      display: block;
      width: 100%;
      text-align: center;
      background-color: #4caf50;
      color: white;
      padding: 0.75rem;
      border: none;
      border-radius: 4px;
      font-size: 1.1rem;
      cursor: pointer;
      margin-top: 2rem;
      text-decoration: none;
      transition: background-color 0.3s;
  
      &:hover {
        background-color: #45a049;
      }
    }
  }
  </style>
  
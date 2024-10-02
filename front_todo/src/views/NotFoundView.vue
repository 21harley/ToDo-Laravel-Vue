<template>
    <div class="not-found">
      <h1>404 - Página no encontrada</h1>
      <p>La página que estás buscando no existe.</p>
      <router-link to="/">Volver al inicio</router-link>
    </div>
  </template>
  
  <script setup lang="ts">
  // Aquí puedes añadir lógica si es necesario, por ejemplo, registrar el error o redirigir automáticamente.
  </script>
  
  <style scoped lang="scss">
  .not-found {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    text-align: center;
    
    h1 {
      font-size: 3rem;
      color: #e74c3c;
    }
    
    p {
      font-size: 1.5rem;
      margin: 1rem 0;
    }
  
    a {
      color: #3498db;
      text-decoration: none;
      font-weight: bold;
      &:hover {
        text-decoration: underline;
      }
    }
  }
  </style>
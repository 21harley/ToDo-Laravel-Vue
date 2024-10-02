<template>
  <div class="dashboard-container">
    <aside class="sidebar">
      <h2>Panel de Control</h2>
      <ul>
        <li><router-link to="/note">Ver Notas</router-link></li>
        <li><router-link to="/create-note">Crear Nota</router-link></li>
      </ul>
      <div class="user-info">
        <h3>Información del Usuario</h3>
        <p><strong>ID:</strong> {{ user?.id }}</p>
        <p><strong>Nombre:</strong> {{ user?.name }}</p>
        <p><strong>Email:</strong> {{ user?.email }}</p>
        <p><strong>Registrado el:</strong> {{ formatDate(user?.created_at ?? '') }}</p>
      </div>
      <button @click="logout">Logout</button>
    </aside>
    
    <section class="main-content">
      <h2>Notas</h2>
      <div class="search-container">
        <button @click="fetchNotes('creation_date')">Ordenar por Fecha de Creación</button>
        <button @click="fetchNotes('due_date')">Ordenar por Fecha de Vencimiento</button>
      </div>
      <table class="notes-table">
        <thead>
          <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Creación</th>
            <th>Expiración</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="note in notes" :key="note.id">
            <td>{{ note.title }}</td>
            <td>{{ note.description }}</td>
            <td>{{ formatDate(note.creation_date) }}</td>
            <td>{{ formatDate(note.due_date) }}</td>
            <td>
              <button @click="editNote(note.id)">Editar</button>
              <button @click="deleteNote(note.id)">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Nota from './../type/note';
import store from '@/store';
import User from './../type/user';
import apiClient from '@/axios';

const user = ref<User | null>(null);
const notes = ref<Nota[]>([]);
const router = useRouter();


const getUserFromLocalStorage = () => {
  const storedUser = localStorage.getItem('user');
  return storedUser ? JSON.parse(storedUser) : null;
};


const initializeUser = () => {
  user.value = store.state.user || getUserFromLocalStorage();
  if (!user.value) {
    router.push('/');
  } else {
    store.commit('setUser', user.value);
  }
};

const getNotesFromLocalStorage = () => {
  const storedNotes = localStorage.getItem('notes');
  return storedNotes ? JSON.parse(storedNotes) : [];
};


const fetchNotes = async (sortBy: string) => {
  try {
    const response = await apiClient.get(`/api/notes/sorted?sort_by=${sortBy}`);
    notes.value = response.data.notes;
    
    localStorage.setItem('notes', JSON.stringify(notes.value));
  } catch (error) {
    console.error('Error fetching notes:', error);

    notes.value = getNotesFromLocalStorage();
  }
};


const editNote = (id: number) => {
  router.push(`/edit-note/${id}`);
};

const deleteNote = async (id: number) => {
  try {
    await apiClient.delete(`/api/notes/${id}`);
    notes.value = notes.value.filter((note) => note.id !== id);
    localStorage.setItem('notes', JSON.stringify(notes.value));
  } catch (error) {
    console.error('Error deleting note:', error);
  }
};

const formatDate = (dateString: string) => {
  const options: Intl.DateTimeFormatOptions = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};

const logout = () => {
  store.dispatch('logout');
  localStorage.removeItem('user');
  localStorage.removeItem('notes');
  router.push('/');
};

onMounted(() => {
  initializeUser(); // Inicializar el usuario
  fetchNotes('creation_date'); // Cargar notas por fecha de creación
});
</script>

<style scoped lang="scss">
.dashboard-container {
  display: flex;
}

.sidebar {
  width: 250px;
  background-color: #f0f0f0;
  padding: 1rem;
  border-right: 1px solid #ddd;

  h2 {
    margin-bottom: 1.5rem;
    color: #4caf50;
  }

  ul {
    list-style: none;
    padding: 0;

    li {
      margin: 1rem 0;
    }

    a {
      color: #4caf50;
      text-decoration: none;
      font-weight: bold;
    }
  }

  .user-info {
    margin-top: 2rem;
    p {
      margin: 0.5rem 0;
    }
  }
}

.main-content {
  flex: 1;
  padding: 2rem;

  h2 {
    color: #4caf50;
    margin-bottom: 1.5rem;
  }

  .search-container {
    margin-bottom: 1rem;

    button {
      margin-right: 0.5rem;
      background-color: #4caf50;
      color: white;
      border: none;
      padding: 0.5rem;
      cursor: pointer;

      &:hover {
        background-color: #45a049;
      }
    }
  }

  .notes-table {
    width: 100%;
    border-collapse: collapse;

    th, td {
      padding: 0.75rem;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #f9f9f9;
    }

    button {
      margin-right: 0.5rem;
      background-color: #4caf50;
      color: white;
      border: none;
      padding: 0.5rem;
      cursor: pointer;

      &:hover {
        background-color: #45a049;
      }
    }

    a {
      color: #4caf50;
      text-decoration: none;

      &:hover {
        text-decoration: underline;
      }
    }
  }
}
</style>

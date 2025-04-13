<template>
  <div class="header-container">
    <HeaderComponent :buttonText="'Novo Usuario'" @button-click="openModalNovoUsuario" @search="handleSearch"/>
    <UsuarioTable :users="filteredUsuarios" @edit="editUsuario" @delete="deleteUsuario" />
    
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import HeaderComponent from '../components/fixed/HeaderComponent.vue'
import UsuarioTable from '@/components/tables/UsuarioTable.vue'
import axios from 'axios'

const usuarios = ref([])
const filteredUsuarios = ref([])

const fetchUsuarios = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/usuario') 
    usuarios.value = response.data
  } catch (error) {
    console.error("Error fetching users:", error)
  }
}

onMounted(async () => {
  await fetchUsuarios()
  filteredUsuarios.value = usuarios.value
})

const openModalNovoUsuario = () => {}

const editUsuario = (usuario) => {
  console.log('Edit', usuario)
}

const deleteUsuario = (usuario) => {
  console.log('Delete', usuario)
}

const handleSearch = (searchQuery) => {
  if (searchQuery) {
    filteredUsuarios.value = usuarios.value.filter(usuario =>
      usuario.usu_email.toLowerCase().includes(searchQuery.toLowerCase())
    )
  } else {
    filteredUsuarios.value = usuarios.value // If the search is cleared, show all users
  }
}
</script>

<style scoped>
.header-container {
  width: 100%;
  position: relative;
}

.usuario-table {
  margin-top: 80px; /* Ensure the table is below the header */
  /* Add any other styling you need */
}
</style>

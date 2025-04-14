<template>
  <div class="header-container">
    <HeaderComponent :buttonText="'Novo Usuario'" @button-click="openModalNovoUsuario" @search="handleSearch"/>
    <CreateUserModal v-model:isVisible="isModalVisible"  @userCreated="fetchUsuarios" />
    <UsuarioTable :users="filteredUsuarios" @edit="editUsuario" @delete="deleteUsuario" />

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import HeaderComponent from '@/components/fixed/HeaderComponent.vue'
import UsuarioTable from '@/components/tables/UsuarioTable.vue'
import axios from 'axios'
import CreateUserModal from '@/components/modals/CreateUserModal.vue'

const filteredUsuarios = ref([])
const usuarios = ref([])
const isModalVisible = ref(false)

const fetchUsuarios = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/usuario') 
    filteredUsuarios.value = response.data
    usuarios.value = response.data
  } catch (error) {
    console.error("Erro ao buscar usuários:", error)
  }
}

onMounted(async () => {
  await fetchUsuarios()
})

const openModalNovoUsuario = () => {
  isModalVisible.value = true
}

const editUsuario = (usuario) => {
  console.log('Edit', usuario)
}

const deleteUsuario = async (usuario) => {
  try {
    const response = await axios.delete(`http://localhost:8000/api/usuario/${usuario.usu_id}`)
    console.log(`Usuário ${usuario.usu_nome} deletado com sucesso.`)
    
    // Re-fetch the users after deletion
    await fetchUsuarios()
  } catch (error) {
    console.error('Erro ao deletar usuário:', error.response?.data || error)
  }
}

const handleSearch = (searchQuery) => {
  if (searchQuery) {
    filteredUsuarios.value = usuarios.value.filter(usuario =>
      usuario.usu_email.toLowerCase().includes(searchQuery.toLowerCase())
    )
  } else {
    filteredUsuarios.value = usuarios.value
  }
}
</script>

<style scoped>
.header-container {
  width: 100%;
  position: relative;
}
</style>

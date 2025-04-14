<template>
  <div class="header-container">
    <HeaderComponent :buttonDisabled="true" @search="handleSearch"/>
    <!-- <CreateCursoModal v-model:isVisible="isModalVisible" @cursoCreated="fetchCursos" /> -->
    <MeusCursosTable :inscricoes="filteredInscricoes"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeMount } from 'vue'
import axios from 'axios'

import HeaderComponent from '@/components/fixed/HeaderComponent.vue'
import MeusCursosTable from '../components/tables/MeusCursosTable.vue'

import { useUserStore } from '../stores/user'

const filteredInscricoes = ref([])
const inscricoes = ref([])
const isModalVisible = ref(false)
const user = useUserStore().user

const fetchInscricoes = async () => {
  try {
    const response = await axios.get(`http://localhost:8000/api/inscricao/aluno/${user.usu_id}`)
    filteredInscricoes.value = response.data
    inscricoes.value = response.data
  } catch (error) {
    console.error('Erro ao buscar inscrições:', error)
  }
}

onBeforeMount(async () => {
  await fetchInscricoes()
})

const openModalNovoCurso = () => {
  isModalVisible.value = true
}

const editCurso = (curso) => {
  console.log('Edit', curso)
  // You could open a modal here with curso data
}

const deleteCurso = async (curso) => {
  try {
    await axios.delete(`http://localhost:8000/api/curso/${curso.cur_id}`)
    console.log(`Curso ${curso.cur_nome} deletado com sucesso.`)
    await fetchCursos()
  } catch (error) {
    console.error('Erro ao deletar curso:', error.response?.data || error)
  }
}

const viewAlunos = (curso) => {
  console.log('Ver alunos do curso:', curso)
}

const handleSearch = (searchQuery) => {
  if (searchQuery) {
    filteredInscricoes.value = inscricoes.value.filter(inscricao =>
      inscricao.curso?.cur_nome.toLowerCase().includes(searchQuery.toLowerCase())
    )
  } else {
    filteredInscricoes.value = inscricoes.value
  }
}
</script>

<style scoped>
.header-container {
  width: 100%;
  position: relative;
}

</style>

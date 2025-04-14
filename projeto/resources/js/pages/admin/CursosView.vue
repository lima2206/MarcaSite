<template>
  <div class="header-container">
    <HeaderComponent :buttonText="'Novo Curso'" @button-click="openModalNovoCurso" @search="handleSearch"/>
    <CreateCursoModal v-model:isVisible="isModalVisible" @cursoCreated="fetchCursos" />
    <CursoTable
      :cursos="filteredCursos"
      @edit="editCurso"
      @delete="deleteCurso"
      @view-students="viewAlunos"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

import HeaderComponent from '@/components/fixed/HeaderComponent.vue'
import CursoTable from '@/components/tables/CursoTable.vue'
import CreateCursoModal from '@/components/modals/CreateCursoModal.vue'

const cursos = ref([])
const filteredCursos = ref([])
const isModalVisible = ref(false)

const fetchCursos = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/curso')
    cursos.value = response.data
    filteredCursos.value = response.data
  } catch (error) {
    console.error('Erro ao buscar cursos:', error)
  }
}

onMounted(async () => {
  await fetchCursos()
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
    filteredCursos.value = cursos.value.filter(curso =>
      curso.cur_nome.toLowerCase().includes(searchQuery.toLowerCase())
    )
  } else {
    filteredCursos.value = cursos.value
  }
}
</script>

<style scoped>
.header-container {
  width: 100%;
  position: relative;
}

</style>

<template>
  <div class="header-container">
    <HeaderComponent :buttonText="'Novo Curso'" @button-click="openModalNovoCurso" @search="handleSearch"/>
    <EditarCursoModal v-model:isVisible="isEditarCursoModalVisible" :curso="selectedCurso" @updated="fetchCursos"/>
    <CreateCursoModal v-model:isVisible="isCreateCursoModalVisible" @cursoCreated="fetchCursos" />
    <ViewAlunosModal v-model:isVisible="isViewAlunoModalVisible" :cursoId="selectedCurso?.cur_id" />
    <CursoTable
      :cursos="filteredCursos"
      @edit="editCurso"
      @delete="deleteCurso"
      @view-alunos="viewAlunos"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

import HeaderComponent from '@/components/fixed/HeaderComponent.vue'
import CursoTable from '@/components/tables/CursoTable.vue'
import CreateCursoModal from '@/components/modals/CreateCursoModal.vue'
import ViewAlunosModal from '../../components/modals/ViewAlunosModal.vue'
import EditarCursoModal from '../../components/modals/EditarCursoModal.vue'

const cursos = ref([])
const filteredCursos = ref([])

const isCreateCursoModalVisible = ref(false)
const isViewAlunoModalVisible = ref(false)
const isEditarCursoModalVisible = ref(false)

const selectedCurso = ref(null)



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
  isCreateCursoModalVisible.value = true
}

const editCurso = (curso) => {
  isEditarCursoModalVisible.value = true
  selectedCurso.value = curso
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
  selectedCurso.value = curso
  isViewAlunoModalVisible.value = true
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

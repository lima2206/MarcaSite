<template>
  <HeaderComponent :buttonDisabled="true" @search="handleSearch" />
  <IncricaoCursoModal v-model:isVisible="modalVisible" :curso="cursoEscolhido"/>
  <div style="display: flex; flex-wrap: wrap; gap: 20px; padding: 20px;">
    <CursoCard
      v-for="curso in filteredCursos"
      :key="curso.cur_id"
      :image="'https://picsum.photos/300/300?random=' + curso.cur_id"
      :title="curso.cur_nome"
      :valor="curso.cur_valor"
      :onClick="() => comprarCurso(curso)"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import CursoCard from '../components/cards/CursoCard.vue'
import HeaderComponent from '../components/fixed/HeaderComponent.vue'
import IncricaoCursoModal from '../components/modals/IncricaoCursoModal.vue'

const cursos = ref([])
const filteredCursos = ref([])
const modalVisible = ref(false)
const cursoEscolhido = ref()

const fetchCursos = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/curso')
    cursos.value = response.data
    filteredCursos.value = response.data
  } catch (error) {
    console.error('Erro ao buscar cursos:', error)
  }
}

onMounted(fetchCursos)

const comprarCurso = (curso) => {
  cursoEscolhido.value = curso
  modalVisible.value = true
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

<template>
  <div class="header-container">
    <HeaderComponent :buttonDisabled="true" @search="handleSearch"/>
    <MeusCursosTable
    :inscricoes="filteredInscricoes"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

import HeaderComponent from '@/components/fixed/HeaderComponent.vue'
import MeusCursosTable from '../components/tables/MeusCursosTable.vue'



import { useUserStore } from '../stores/user'

const filteredInscricoes = ref([])
const inscricoes = ref([])
const user = useUserStore().user
const isPaymentVisible = ref(false)


const fetchInscricoes = async () => {
  try {
    const response = await axios.get(`http://localhost:8000/api/inscricao/aluno/${user.usu_id}`)
    filteredInscricoes.value = response.data
    inscricoes.value = response.data
  } catch (error) {
    console.error('Erro ao buscar inscrições:', error)
  }
}

onMounted(async () => {
  await fetchInscricoes()
})


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

<template>
  <div>
    <div class="filters">
      <input type="text" v-model="filters.nome" placeholder="Filtrar por nome" />
      <select v-model="filters.status">
        <option value="">Todos os Status</option>
        <option value="pendente">Pendente</option>
        <option value="aprovado">Aprovado</option>
        <option value="recusado">Recusado</option>
      </select>
      <input type="date" v-model="filters.data" />
    </div>

    <table class="aluno-table">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Data de Inscrição</th>
          <th>Email</th>
          <th>Status</th>
          <th>Valor Pago</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(inscricao, index) in filteredInscricoes" :key="index">
          <td>{{ inscricao.aluno.usu_nome }}</td>
          <td>{{ formatDate(inscricao.ins_data_inscricao) }}</td>
          <td>{{ inscricao.aluno.usu_email }}</td>
          <td>
            <select class="invisible-select" v-model="inscricao.ins_status" @change="updateStatus(inscricao)">
              <option value="pendente">Pendente</option>
              <option value="aprovado">Aprovado</option>
              <option value="recusado">Recusado</option>
            </select>
          </td>
          <td>R$ {{ Number(inscricao.valor_pago).toFixed(2) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { format } from 'date-fns'
import { computed, reactive } from 'vue'
import axios from 'axios'

const props = defineProps({
  inscricoes: Array
})

function formatDate(date) {
  if (!date) return '—'
  try {
    return format(new Date(date), 'dd/MM/yyyy')
  } catch {
    return date
  }
}

const filters = reactive({
  nome: '',
  status: '',
  data: ''
})

const filteredInscricoes = computed(() => {
  return props.inscricoes.filter(inscricao => {
    const nomeMatch = inscricao.aluno.usu_nome.toLowerCase().includes(filters.nome.toLowerCase())
    const statusMatch = filters.status ? inscricao.ins_status === filters.status : true
    const dataMatch = filters.data
      ? new Date(inscricao.ins_data_inscricao).toISOString().split('T')[0] === filters.data
      : true

    return nomeMatch && statusMatch && dataMatch
  })
})

const updateStatus = async (inscricao) => {
  try {
    await axios.put(`http://localhost:8000/api/inscricao/${inscricao.id}`, {
      ins_status: inscricao.ins_status,
    })
    console.log('Status atualizado com sucesso')
  } catch (error) {
    console.error('Erro ao atualizar status:', error)
  }
}
</script>

<style scoped>
.aluno-table {
  width: 100%;
  border-collapse: collapse;
  font-family: sans-serif;
  margin-top: 16px;
}

.aluno-table th,
.aluno-table td {
  padding: 10px;
  text-align: center;
  border-bottom: 1px solid #ddd;
}

.filters {
  display: flex;
  gap: 12px;
  margin-bottom: 12px;
}

.filters input,
.filters select {
  padding: 6px;
  border-radius: 4px;
  border: 1px solid #ccc;
}

.invisible-select {
  background: none;
  border: none;
  font: inherit;
  color: inherit;
  text-align: center;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 0;
  cursor: pointer;
  width: 100%;
}
</style>

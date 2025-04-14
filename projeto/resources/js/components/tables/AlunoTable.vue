<template>
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
      <tr v-for="(inscricao, index) in inscricoes" :key="index">
        <td>{{ inscricao.aluno.usu_nome }}</td>
        <td>{{ formatDate(inscricao.ins_data_inscricao) }}</td>
        <td>{{ inscricao.aluno.usu_email }}</td>
        <td>{{ inscricao.ins_status }}</td>
        <td>R$ {{ Number(inscricao.valor_pago).toFixed(2) }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { format } from 'date-fns'

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
</script>

<style scoped>
.aluno-table {
  width: 100%;
  border-collapse: collapse;
  font-family: sans-serif;
}

.aluno-table th,
.aluno-table td {
  padding: 10px;
  text-align: center;
  border-bottom: 1px solid #ddd;
}
</style>

<template>
  <table class="curso-table">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Data de Inscrição</th>
        <th>Status</th>
        <th>Valor Pago</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(inscricao, index) in inscricoes" :key="index">
        <td>{{ inscricao.curso?.cur_nome }}</td>
        <td>{{ formatDate(inscricao.ins_data_inscricao) }}</td>
        <td>{{ inscricao.ins_status }}</td>
        <td>R$ {{ inscricao.valor_pago != null ? Number(inscricao.valor_pago).toFixed(2) : '0,00' }}</td>
        <td class="actions">
          <button title="Ver Alunos">
            <EyeIcon class="icon" />
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { EyeIcon } from '@heroicons/vue/solid'

import { format } from 'date-fns'


const props = defineProps({
  inscricoes: Array
})

const emit = defineEmits(['ver-pagamento'])



function formatDate(dateString) {
  if (!dateString) return 'Data inválida'
  try {
    return format(new Date(dateString), 'dd/MM/yyyy')
  } catch {
    return dateString
  }
}
</script>

<style scoped>
.curso-table {
  width: 100%;
  border-collapse: collapse;
  font-family: sans-serif;
}

.curso-table th,
.curso-table td {
  padding: 12px;
  padding-left: 20px;
  text-align: Left;
  border-bottom: 1px solid #ddd;
}

.curso-table th {
  font-weight: bold;
}

.actions {
  display: flex;
  gap: 10px;
}

.actions button {
  background: none;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon {
  width: 20px;
  height: 20px;
  color: #333;
}

.actions button:hover .icon {
  transform: scale(1.1);
  transition: transform 0.2s;
}
</style>

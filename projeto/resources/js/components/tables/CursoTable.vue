<template>
  <table class="curso-table">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Valor</th>
        <th>Ativo</th>
        <th>Período de Inscrição</th>
        <th>Vagas Restantes</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(curso, index) in cursos" :key="index">
        <td>{{ curso.cur_nome }}</td>
        <td>R$ {{ curso.cur_valor != null ? Number(curso.cur_valor).toFixed(2) : '0,00' }}</td>
        <td>{{ curso.cur_ativo ? 'Sim' : 'Não' }}</td>
        <td>{{ formatDate(curso.cur_data_inscricoes_inicio) }} até {{ formatDate(curso.cur_data_inscricoes_fim) }}</td>
        <td>{{ curso.cur_vagas - (curso.alunos?.length || 0) }}</td>
        <td class="actions">
          <button @click="viewAlunos(curso)" title="Ver Alunos">
            <UserGroupIcon class="icon" />
          </button>
          <button @click="editCurso(curso)" title="Editar">
            <PencilIcon class="icon" />
          </button>
          <button @click="deleteCurso(curso)" title="Excluir">
            <TrashIcon class="icon" />
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { PencilIcon, TrashIcon, UserGroupIcon } from '@heroicons/vue/solid'
import { format } from 'date-fns'

const props = defineProps({
  cursos: Array
})

const emit = defineEmits(['edit', 'delete', 'view-alunos'])

function editCurso(curso) {
  emit('edit', curso)
}

function deleteCurso(curso) {
  emit('delete', curso)
}

function viewAlunos(curso) {
  emit('view-alunos', curso)
}

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
  text-align: center;
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

<template>
  <table class="course-table">
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
      <tr v-for="(curso, index) in courses" :key="index">
        <td>{{ curso.name }}</td>
        <td>R$ {{ curso.price.toFixed(2) }}</td>
        <td>{{ curso.active ? 'Sim' : 'Não' }}</td>
        <td>{{ curso.registrationPeriodStart }} até {{ curso.registrationPeriodEnd }}</td>
        <td>{{ curso.vagas - curso.enrolledStudents.length }}</td>
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

const props = defineProps({
  courses: Array
})

const emit = defineEmits(['edit', 'delete', 'view-students'])

function editCurso(curso) {
  emit('edit', curso)
}

function deleteCurso(curso) {
  emit('delete', curso)
}

function viewAlunos(curso) {
  emit('view-students', curso)
}
</script>

<style scoped>
.course-table {
  width: 100%;
  border-collapse: collapse;
  font-family: sans-serif;
}

.course-table th,
.course-table td {
  padding: 12px;
  text-align: center;
  border-bottom: 1px solid #ddd;
}

.course-table th {
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

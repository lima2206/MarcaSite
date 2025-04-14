<template>
  <table class="user-table">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Tipo</th>
        <th>Ativo</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(user, index) in users" :key="index">
        <td>{{ user.usu_nome }}</td>
        <td>{{ user.usu_email }}</td>
        <td>{{ user.usu_is_adm ? 'Administrador' : 'Aluno' }}</td>
        <td>{{ user.usu_ativo ? 'Sim' : 'Não' }}</td>
        <td class="actions">
          <button @click="editUser(user)" title="Editar">
            <PencilIcon class="icon" />
          </button>
          <button @click="deleteUsuario(user)" title="Excluir">
            <TrashIcon class="icon" />
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { PencilIcon, TrashIcon } from '@heroicons/vue/solid'

const emit = defineEmits(['edit', 'delete'])

const props = defineProps({
  users: Array
})

function editUser(user) {
  emit('edit', user)
}

function deleteUsuario(user) {
  emit('delete', user)
}

</script>

<style scoped>
.user-table {
  width: 100%;
  border-collapse: collapse;
  font-family: sans-serif;
}

.user-table th,
.user-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.user-table th {
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
  padding: 0;
}

.icon {
  width: 20px;
  height: 20px;
  color: #333;
}

.actions button:hover .icon {
  transform: scale(1.1);
  color: #000;
}
</style>

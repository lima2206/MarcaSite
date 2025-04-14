<template>
<div v-if="props.isVisible" class="modal-overlay">
    <div class="modal-content">
      <h2>Novo Usuário</h2>
      <p>Detalhes do Usuário</p>

      <form @submit.prevent="handleSubmit">
        <div class="form-group">
          <div class="left-column">
            <InputComponent
              label="Nome"
              id="name"
              v-model="userData.usu_nome"
            />
            <span v-if="errors.name" class="error">{{ errors.name }}</span>
          </div>
          <div class="right-column">
            <DrawerSelector
              label="Tipo de Usuário"
              id="role"
              :options="roles"
              v-model="userData.tipo"
            />
            <span v-if="errors.role" class="error">{{ errors.role }}</span>
          </div>
        </div>

        <InputComponent
          label="Email"
          id="email"
          type="email"
          v-model="userData.usu_email"
        />
        <span v-if="errors.email" class="error">{{ errors.email }}</span>

        <div class="form-group">
          <div class="left-column">
            <InputComponent
              label="Senha"
              id="password"
              type="password"
              v-model="userData.usu_senha"
            />
            <span v-if="errors.password" class="error">{{ errors.password }}</span>
          </div>
          <div class="right-column">
            <InputComponent
              label="Confirmação de Senha"
              id="confirmPassword"
              type="password"
              v-model="userData.confirmPassword"
            />
            <span v-if="errors.confirmPassword" class="error">{{ errors.confirmPassword }}</span>
          </div>
        </div>

        <div class="modal-actions">
          <ButtonComponent type="submit">Adicionar</ButtonComponent>
          <ButtonComponent isLight type="button" @click="closeModal">Cancelar</ButtonComponent>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import InputComponent from '../inputs/InputComponent.vue'
import DrawerSelector from '../inputs/DrawerSelector.vue'
import ButtonComponent from '../buttons/ButtonComponent.vue'

const props = defineProps({ isVisible: Boolean })
const emit = defineEmits(['update:isVisible', 'userCreated'])

const userData = ref({
  usu_nome: '',
  usu_email: '',
  usu_senha: '',
  confirmPassword: '',
  tipo: '',
  usu_is_adm: false
})

const errors = ref({})

const roles = ['Administrador', 'Aluno']

const handleSubmit = async () => {
  errors.value = {}

  if (!userData.value.usu_nome) errors.value.name = 'Nome é obrigatório.'
  if (!userData.value.usu_email) errors.value.email = 'Email é obrigatório.'
  if (!userData.value.tipo) errors.value.role = 'Tipo de usuário é obrigatório.'
  if (!userData.value.usu_senha) errors.value.password = 'Senha é obrigatória.'
  if (userData.value.usu_senha && userData.value.usu_senha.length < 6) {
    errors.value.password = 'A senha deve ter pelo menos 6 caracteres.'
  }
  if (!userData.value.confirmPassword) errors.value.confirmPassword = 'Confirme a senha.'
  if (
    userData.value.usu_senha &&
    userData.value.confirmPassword &&
    userData.value.usu_senha !== userData.value.confirmPassword
  ) {
    errors.value.confirmPassword = 'As senhas não coincidem.'
  }

  if (Object.keys(errors.value).length > 0) return

  // Se o tipo for adm is adm é true
  userData.value.usu_is_adm = userData.value.tipo === 'Administrador'

  const request ={
      usu_nome: userData.value.usu_nome,
      usu_email: userData.value.usu_email,
      usu_senha: userData.value.usu_senha,
      usu_is_adm: userData.value.usu_is_adm
    }

  try {
    await axios.post('http://127.0.0.1:8000/api/usuario', request)

    console.log('Usuário criado com sucesso.')

    emit('userCreated')
    closeModal()
  } catch (error) {
    console.error('Erro ao criar usuário:', error.response?.data || error)
  }
}

const closeModal = () => {
  emit('update:isVisible', false)
}


</script>

<style scoped>
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  overflow-y: auto;
  padding: 20px;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 100%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
}

h2 {
  margin-bottom: 8px;
  font-size: 1.5rem;
}

p {
  margin-bottom: 20px;
  color: gray;
}

.form-group {
  display: flex;
  justify-content: space-between;
  margin-bottom: 12px;
}

.left-column,
.right-column {
  width: 48%;
}

.modal-actions {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.modal-actions button {
  width: 48%;
}

.error {
  color: red;
  font-size: 0.85rem;
  margin-top: 4px;
  display: block;
}
</style>

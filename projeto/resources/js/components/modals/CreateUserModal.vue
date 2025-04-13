<template>
  <div v-if="isVisible" class="modal-overlay">
    <div class="modal-content">
      <h2>Nova Usuário</h2>
      <p>Detalhes do Usuário</p>

      <form @submit.prevent="handleSubmit">
        <div class="form-group">
          <div class="left-column">
            <InputComponent
              label="Nome"
              id="name"
              v-model="userData.name"
            />
            <span v-if="errors.name" class="error">{{ errors.name }}</span>
          </div>
          <div class="right-column">
            <DrawerSelector
              label="Tipo de Usuário"
              id="role"
              :options="roles"
              v-model="userData.role"
            />
            <span v-if="errors.role" class="error">{{ errors.role }}</span>
          </div>
        </div>

        <InputComponent
          label="Email"
          id="email"
          type="email"
          v-model="userData.email"
        />
        <span v-if="errors.email" class="error">{{ errors.email }}</span>

        <div class="form-group">
          <div class="left-column">
            <InputComponent
              label="Senha"
              id="password"
              type="password"
              v-model="userData.password"
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
import { ref } from 'vue';
import InputComponent from '../inputs/InputComponent.vue';
import DrawerSelector from '../inputs/DrawerSelector.vue';
import ButtonComponent from '../buttons/ButtonComponent.vue';

const isVisible = ref(true);
const userData = ref({
  name: '',
  email: '',
  password: '',
  confirmPassword: '',
  role: '',
});

const errors = ref({});

const roles = ['Administrador', 'Aluno'];

const handleSubmit = () => {
  errors.value = {};

  if (!userData.value.name) errors.value.name = 'Nome é obrigatório.';
  if (!userData.value.email) errors.value.email = 'Email é obrigatório.';
  if (!userData.value.role) errors.value.role = 'Tipo de usuário é obrigatório.';
  if (!userData.value.password) errors.value.password = 'Senha é obrigatória.';
  if (!userData.value.confirmPassword) errors.value.confirmPassword = 'Confirme a senha.';
  if (
    userData.value.password &&
    userData.value.confirmPassword &&
    userData.value.password !== userData.value.confirmPassword
  ) {
    errors.value.confirmPassword = 'As senhas não coincidem.';
  }

  if (Object.keys(errors.value).length > 0) {
    return;
  }

  //handle submit

  console.log('Usuário criado: ', userData.value);
  closeModal();
};

const closeModal = () => {
  isVisible.value = false;
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 500px;
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

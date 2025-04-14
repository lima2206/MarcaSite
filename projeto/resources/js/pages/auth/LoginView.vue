<template>
  <div class="auth-form">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <InputComponent label="Email" id="usu_email" v-model="usu_email" />
      <InputComponent label="Senha" id="usu_senha" type="password" v-model="usu_senha" />
      <ButtonComponent type="submit">Entrar</ButtonComponent>
    </form>
    <router-link to="/register">Criar conta</router-link>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/user'
import InputComponent from '@/components/inputs/InputComponent.vue'
import ButtonComponent from '@/components/buttons/ButtonComponent.vue'
import axios from 'axios'

const usu_email = ref('')
const usu_senha = ref('')
const router = useRouter()
const userStore = useUserStore()

async function login() {
  try {
    const res = await axios.post('http://localhost:8000/api/login', {
      usu_email: usu_email.value,
      usu_senha: usu_senha.value
    });

    userStore.setUser(res.data);
    router.push('/');
  } catch (error) {
    alert(error.response?.data?.message || 'Erro ao fazer login');
  }
}

</script>

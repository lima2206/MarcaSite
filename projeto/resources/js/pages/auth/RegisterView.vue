<template>
  <div class="auth-form">
    <h2>Cadastro</h2>
    <form @submit.prevent="register">
      <InputComponent label="Nome" id="usu_nome" v-model="usu_nome" />
      <InputComponent label="Email" id="usu_email" v-model="usu_email" />
      <InputComponent label="Senha" id="usu_senha" type="password" v-model="usu_senha" />
      <ButtonComponent type="submit">Cadastrar</ButtonComponent>
    </form>
    <router-link to="/login">Já tem conta?</router-link>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import InputComponent from '@/components/inputs/InputComponent.vue'
import ButtonComponent from '@/components/buttons/ButtonComponent.vue'
import axios from 'axios'

const usu_nome = ref('')
const usu_email = ref('')
const usu_senha = ref('')
const router = useRouter()

async function register() {
  const request = { usu_nome: usu_nome.value, usu_email: usu_email.value, usu_senha: usu_senha.value }

  try {
    await axios.post('http://127.0.0.1:8000/api/usuario', request)
  } catch (error) {
    console.error('Erro ao criar curso:', error.response?.data || error)
  }

  

  router.push('/login')
}
</script>

<style>

</style>

<template>
  <div v-if="props.isVisible" class="modal-overlay">
    <div class="modal-content">
      <h2>Nova Inscrição</h2>
      <p>Preencha os dados do participante</p>

      <form @submit.prevent="handleSubmit">
        <InputComponent label="Nome" id="nome" v-model="form.nome" />
        <span v-if="errors.nome" class="error">{{ errors.nome }}</span>

        <InputComponent label="Email" id="email" v-model="form.email" />
        <span v-if="errors.email" class="error">{{ errors.email }}</span>

        <InputComponent label="CPF" id="cpf" v-model="form.cpf" />
        <span v-if="errors.cpf" class="error">{{ errors.cpf }}</span>

        <InputComponent label="Endereço" id="endereco" v-model="form.endereco" />
        <span v-if="errors.endereco" class="error">{{ errors.endereco }}</span>

        <InputComponent label="Empresa" id="empresa" v-model="form.empresa" />
        <span v-if="errors.empresa" class="error">{{ errors.empresa }}</span>

        <InputComponent label="Telefone" id="telefone" v-model="form.telefone" />
        <span v-if="errors.telefone" class="error">{{ errors.telefone }}</span>

        <InputComponent label="Celular" id="celular" v-model="form.celular" />
        <span v-if="errors.celular" class="error">{{ errors.celular }}</span>

        <DrawerSelector label="Tipo" id="tipo" :options="['Estudante', 'Profissional', 'Associado']"
          v-model="form.tipo" />
        <span v-if="errors.tipo" class="error">{{ errors.tipo }}</span>

        <DrawerSelector label="Curso" id="curso" :options="cursos.map(c => c.cur_nome)" v-model="form.curso" />
        <span v-if="errors.curso" class="error">{{ errors.curso }}</span>

        <div class="modal-actions">
          <ButtonComponent type="submit">Inscrever</ButtonComponent>
          <ButtonComponent isLight type="button" @click="closeModal">Cancelar</ButtonComponent>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import InputComponent from '../inputs/InputComponent.vue'
import DrawerSelector from '../inputs/DrawerSelector.vue'
import ButtonComponent from '../buttons/ButtonComponent.vue'

const props = defineProps({ isVisible: Boolean, curso: Object})
const emit = defineEmits(['update:isVisible', 'inscricaoCreated'])
import { useUserStore } from '../../stores/user'

const user = useUserStore().user
const form = ref({
  nome: user.usu_nome,
  email: user.usu_email,
  cpf: user.usu_cpf,
  endereco: user.usu_endereco,
  empresa: user.usu_empresa,
  telefone: user.usu_telefone,
  celular: user.usu_celular,
  tipo: user.usu_tipo,
  curso: props.curso?.cur_nome || ''
})


watch(() => props.isVisible, (visible) => {
  if (visible) {
    form.value = {
      nome: user.usu_nome,
      email: user.usu_email,
      cpf: user.usu_cpf,
      endereco: user.usu_endereco,
      empresa: user.usu_empresa,
      telefone: user.usu_telefone,
      celular: user.usu_celular,
      tipo: user.usu_tipo || '',
      curso: props.curso?.cur_nome|| ''
    }
    errors.value = {}
  }
})


const errors = ref({})
const cursos = ref([])

const fetchCursos = async () => {
  try {
    const res = await axios.get('http://localhost:8000/api/curso')
    cursos.value = res.data
  } catch (e) {
    console.error('Erro ao buscar cursos:', e)
  }
}

onMounted(fetchCursos)


const handleSubmit = async () => {
  errors.value = {}

  const requiredFields = ['nome', 'email', 'cpf', 'endereco', 'empresa', 'telefone', 'celular', 'tipo', 'curso']
  requiredFields.forEach(field => {
    if (!form.value[field]) errors.value[field] = 'Campo obrigatório.'
  })

  if (Object.keys(errors.value).length > 0) return
  //     await axios.put(`http://localhost:8000/api/usuario/${user.usu_id}`)

  try {

    const usuarioData = { ...form.value }
    delete usuarioData.curso

    await axios.put(`http://localhost:8000/api/usuario/${user.usu_id}`, usuarioData)

    const inscricaoPayload = {
      usu_id: user.usu_id,
      cur_id: props.curso.cur_id,
      ins_status: 'pendente',
      valor_pago: 0.00
    }
    
    await axios.post('http://localhost:8000/api/inscricao', inscricaoPayload)

    emit('inscricaoCreated')

    closeModal()
  } catch (error) {
    console.error('Erro ao salvar inscrição:', error.response?.data || error)
  }
}

const closeModal = () => {
  emit('update:isVisible', false)
}
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
  z-index: 9999;
  overflow: auto;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 500px;
  max-height: 90vh;
  overflow-y: auto;
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

<template>
  <div v-if="props.isVisible" class="modal-overlay">
    <div class="modal-content">
      <h2>Novo Curso</h2>
      <p>Detalhes do Curso</p>

      <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
        <InputComponent label="Nome" id="cur_nome" v-model="cursoData.cur_nome" />
        <span v-if="errors.nome" class="error">{{ errors.nome }}</span>

        <InputComponent label="Descrição" id="cur_descricao" v-model="cursoData.cur_descricao" />
        <span v-if="errors.descricao" class="error">{{ errors.descricao }}</span>

        <InputComponent label="Valor (R$)" id="cur_valor" type="number" step="0.01" v-model="cursoData.cur_valor" />
        <span v-if="errors.valor" class="error">{{ errors.valor }}</span>

        <div class="form-group">
          <div class="left-column">
            <InputComponent label="Início das Inscrições" id="cur_data_inscricoes_inicio" type="date"
              v-model="cursoData.cur_data_inscricoes_inicio" />
            <span v-if="errors.inicio" class="error">{{ errors.inicio }}</span>
          </div>
          <div class="right-column">
            <InputComponent label="Fim das Inscrições" id="cur_data_inscricoes_fim" type="date"
              v-model="cursoData.cur_data_inscricoes_fim" />
            <span v-if="errors.fim" class="error">{{ errors.fim }}</span>
          </div>
        </div>

        <div class="form-group">
          <div class="left-column">
            <InputComponent label="Vagas" id="cur_vagas" type="number" v-model="cursoData.cur_vagas" />
            <span v-if="errors.vagas" class="error">{{ errors.vagas }}</span>
          </div>
          <div class="right-column">
            <DrawerSelector label="Curso Ativo" id="cur_ativo" :options="['Sim', 'Não']"
              v-model="cursoData.cur_ativo_display" />
            <span v-if="errors.ativo" class="error">{{ errors.ativo }}</span>
          </div>
        </div>

        <!-- Novo campo para a imagem -->
        <div class="form-group">
          <label for="cur_imagem">Imagem do Curso</label>
          <input type="file" id="cur_imagem" @change="handleFileChange($event, 'cur_imagem')" />
        </div>

        <!-- Novo campo para o material -->
        <div class="form-group">
          <label for="cur_material">Material (PDF)</label>
          <input type="file" id="cur_material" @change="handleFileChange($event, 'cur_material')" />
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
import { ref, toRaw } from 'vue'
import axios from 'axios'
import InputComponent from '../inputs/InputComponent.vue'
import DrawerSelector from '../inputs/DrawerSelector.vue'
import ButtonComponent from '../buttons/ButtonComponent.vue'

const props = defineProps({ isVisible: Boolean })
const emit = defineEmits(['update:isVisible', 'cursoCreated'])

const cursoData = ref({
  cur_nome: '',
  cur_descricao: '',
  cur_valor: 0,
  cur_data_inscricoes_inicio: '',
  cur_data_inscricoes_fim: '',
  cur_vagas: 0,
  cur_ativo_display: 'Sim',
  cur_imagem: null,  // Adicionado para armazenar o arquivo de imagem
  cur_material: null  // Adicionado para armazenar o arquivo de material
})

const errors = ref({})

const handleFileChange = (event, field) => {
  const file = event.target.files[0]
  if (file) {
    cursoData.value[field] = file
  }
}

const handleSubmit = async () => {
  errors.value = {}

  if (!cursoData.value.cur_nome) errors.value.nome = 'Nome é obrigatório.'
  if (!cursoData.value.cur_descricao) errors.value.descricao = 'Descrição é obrigatória.'
  if (!cursoData.value.cur_valor) errors.value.valor = 'Valor é obrigatório.'
  if (!cursoData.value.cur_data_inscricoes_inicio) errors.value.inicio = 'Data de início é obrigatória.'
  if (!cursoData.value.cur_data_inscricoes_fim) errors.value.fim = 'Data de fim é obrigatória.'
  if (!cursoData.value.cur_vagas) errors.value.vagas = 'Número de vagas é obrigatório.'
  if (!cursoData.value.cur_ativo_display) errors.value.ativo = 'Campo ativo é obrigatório.'

  if (Object.keys(errors.value).length > 0) return

  console.log('Dados antes do envio:', cursoData.value)

  const rawData = toRaw(cursoData.value)


  const formData = new FormData()

  formData.append('cur_nome', rawData.cur_nome)
  formData.append('cur_descricao', rawData.cur_descricao)
  formData.append('cur_valor', rawData.cur_valor)
  formData.append('cur_data_inscricoes_inicio', rawData.cur_data_inscricoes_inicio)
  formData.append('cur_data_inscricoes_fim', rawData.cur_data_inscricoes_fim)
  formData.append('cur_vagas', rawData.cur_vagas)
  formData.append('cur_ativo', rawData.cur_ativo_display === 'Sim' ? 1 : 0)

  // Only append files if they exist
  if (rawData.cur_imagem) {
    formData.append('cur_imagem', rawData.cur_imagem)
  }
  if (rawData.cur_material) {
    formData.append('cur_material', rawData.cur_material)
  }


  for (let pair of formData.entries()) {
    console.log(pair[0] + ', ' + pair[1])
  }


  try {

    console.log(formData)
    const response = await axios.post('http://127.0.0.1:8000/api/curso', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    console.log('Curso created successfully:', response.data)
    emit('cursoCreated')
    closeModal()
  } catch (error) {
    console.error('Erro ao criar curso:', error.response?.data || error)
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

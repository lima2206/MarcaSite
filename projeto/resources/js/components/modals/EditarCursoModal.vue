<template>
  <div v-if="isVisible" class="modal-overlay">
    <div class="modal-content">
      <h2>Editar Curso</h2>
      <form @submit.prevent="submit">
        <InputComponent
          v-for="field in fields"
          :key="field.id"
          v-model="form[field.id]"
          :label="field.label"
          :id="field.id"
        />
        
        <!-- Checkbox para o campo booleano -->
        <div class="checkbox-group">
          <label for="cur_ativo">
            <input
              type="checkbox"
              id="cur_ativo"
              v-model="form.cur_ativo"
            />
            Está Ativo?
          </label>
        </div>

        <!-- Show current image if available -->
        <div v-if="props.curso.cur_imagem">
          <h3>Imagem Atual</h3>
          <img :src="'/storage/' + props.curso.cur_imagem" alt="Imagem do Curso" class="image-preview" />
        </div>

        <!-- Show current material if available -->
        <div v-if="props.curso.cur_material">
          <h3>Material Atual</h3>
          <a :href="'/storage/' + props.curso.cur_material" target="_blank">Baixar Material</a>
        </div>

        <!-- File Inputs for Image and Material -->
        <div class="file-inputs">
          <label for="cur_imagem">Nova Imagem do Curso</label>
          <input
            type="file"
            id="cur_imagem"
            @change="handleFileChange('cur_imagem', $event)"
          />
        </div>

        <div class="file-inputs">
          <label for="cur_material">Novo Material do Curso</label>
          <input
            type="file"
            id="cur_material"
            @change="handleFileChange('cur_material', $event)"
          />
        </div>

        <div class="modal-actions">
          <ButtonComponent type="submit">Salvar</ButtonComponent>
          <ButtonComponent isLight type="button" @click="close">Cancelar</ButtonComponent>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import InputComponent from '../inputs/InputComponent.vue'
import ButtonComponent from '../buttons/ButtonComponent.vue'
import axios from 'axios'

const props = defineProps({ isVisible: Boolean, curso: Object })
const emit = defineEmits(['update:isVisible', 'updated'])

const form = ref({
  cur_imagem: null, 
  cur_material: null
})
const fields = [
  { id: 'cur_nome', label: 'Nome' },
  { id: 'cur_descricao', label: 'Descrição' },
  { id: 'cur_valor', label: 'Valor' },
  { id: 'cur_data_inscricoes_inicio', label: 'Início das Inscrições' },
  { id: 'cur_data_inscricoes_fim', label: 'Fim das Inscrições' },
  { id: 'cur_vagas', label: 'Vagas' }
]

watch(() => props.isVisible, (visible) => {
  if (visible && props.curso) {
    // Reset the form with course data and keep the files null
    form.value = { ...props.curso, cur_imagem: null, cur_material: null }
  }
})

const handleFileChange = (field, event) => {
  // Store the selected file in the form data
  form.value[field] = event.target.files[0]
}

const submit = async () => {
  // Prepare FormData to send the data and files
  const formData = new FormData()
  // Append non-file fields
  for (const key in form.value) {
    formData.append(key, form.value[key])
  }

  try {
    // Send the PUT request with FormData to handle file uploads
    const response = await axios.put(`http://localhost:8000/api/curso/${form.value.cur_id}`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
    emit('updated')
    close()
  } catch (error) {
    console.error('Erro ao atualizar o curso:', error)
  }
}

const close = () => emit('update:isVisible', false)
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

.checkbox-group {
  display: flex;
  justify-content: space-between;
  margin-top: 16px;
}

.checkbox-group label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 500;
}

.file-inputs {
  display: flex;
  justify-content: space-between;
  margin-top: 16px;
}

.image-preview {
  max-width: 100%;
  max-height: 200px;
  object-fit: cover;
  margin-top: 10px;
}
</style>

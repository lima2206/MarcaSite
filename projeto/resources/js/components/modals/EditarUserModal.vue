<template>
  <div v-if="isVisible" class="modal-overlay">
    <div class="modal-content">
      <h2>Editar Usuário</h2>
      <form @submit.prevent="submit">
        <InputComponent
          v-for="field in fields"
          :key="field.id"
          v-model="form[field.id]"
          :label="field.label"
          :id="field.id"
        />

        <DrawerSelector
          v-model="form.usu_tipo"
          label="Tipo"
          id="usu_tipo"
          :options="['Estudante', 'Profissional', 'Associado']"
        />

        <div class="checkbox-group">
          <label>
            <input type="checkbox" v-model="form.usu_is_adm" />
            É Admin?
          </label>
          <label>
            <input type="checkbox" v-model="form.usu_ativo" />
            Está Ativo?
          </label>
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
import DrawerSelector from '../inputs/DrawerSelector.vue'

const props = defineProps({ isVisible: Boolean, usuario: Object })
const emit = defineEmits(['update:isVisible', 'updated'])

const form = ref({

})
const fields = [
  { id: 'usu_email', label: 'Email' },
  { id: 'usu_nome', label: 'Nome' },
  { id: 'usu_cpf', label: 'CPF' },
  { id: 'usu_endereco', label: 'Endereço' },
  { id: 'usu_empresa', label: 'Empresa' },
  { id: 'usu_telefone', label: 'Telefone' },
  { id: 'usu_celular', label: 'Celular' }
]

watch(
  () => [props.isVisible, props.usuario],
  ([visible, usuario]) => {
    if (visible && usuario) {
      form.value = {
        ...usuario,
        usu_is_adm: Boolean(usuario.usu_is_adm),
        usu_ativo: Boolean(usuario.usu_ativo),
      }
    }
  },
  { immediate: true }
)


const submit = async () => {
  
  await axios.put(`http://localhost:8000/api/usuario/${form.value.usu_id}`, form.value)
  emit('updated')
  close()
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
</style>

<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { ListType } from 'naive-ui/es/upload/src/interface'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: keyof GenericData
  label: string
  accept: string
  listType: ListType
  max?: number
  loading?: boolean
  disabled?: boolean
  inputProps?: Record<string, string>
  labelProps?: Record<string, string>
  model: InertiaForm<GenericData>
  validation: Record<keyof GenericData, 'error' | undefined>
}>()

const model = reactive(props.model)
const validation = reactive(props.validation)
const labelProps = computed(() => ({ for: props.path, ...(props.labelProps || {}) }))
const inputProps = computed(() => ({
  ...(props.inputProps || {}),
  autocomplete: props.path,
  name: props.path,
  id: props.path,
}))
</script>

<template>
  <n-form-item
    :path="props.path" :label="props.label"
    :label-props="labelProps"
    :validation-status="validation[props.path]"
    :feedback="model.errors[props.path]"
  >
    <n-upload
      v-model:value="model[props.path]"
      :list-type="props.listType"
      :accept="props.accept"
      :max="props.max"
      :input-props="inputProps"
      :loading="model.processing"
      :disabled="model.processing"
    />
  </n-form-item>
</template>

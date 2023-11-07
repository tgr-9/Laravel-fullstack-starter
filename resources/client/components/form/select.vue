<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { SelectOption } from 'naive-ui'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: keyof GenericData
  label: string
  placeholder?: string
  autofocus?: boolean
  multiple?: boolean
  clearable?: boolean
  loading?: boolean
  disabled?: boolean
  model: InertiaForm<GenericData>
  validation: Record<keyof GenericData, 'error' | undefined>
  options: SelectOption[]
}>()

defineEmits(['search', 'update'])

const model = reactive(props.model)
const validation = reactive(props.validation)
const disabled = computed(() => props.disabled || model.processing)
const loading = computed(() => props.loading || model.processing)
</script>

<template>
  <n-form-item
    :path="props.path" :label="props.label"
    :label-props="{ for: props.path }"
    :validation-status="validation[props.path]"
    :feedback="model.errors[props.path]"
  >
    <n-select
      v-model:value="model[props.path]"
      filterable remote
      :clearable="props.clearable"
      :placeholder="props.placeholder"
      :input-props="{ id: props.path, name: props.path }"
      :options="props.options"
      :multiple="props.multiple"
      :loading="loading"
      :disabled="disabled"
      @search="$emit('search', $event)"
      @update:value="$emit('update', $event)"
    />
  </n-form-item>
</template>

<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { SelectOption } from 'naive-ui'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: keyof GenericData
  model: InertiaForm<GenericData>
  options: SelectOption[]
  label?: string
  placeholder?: string
  autofocus?: boolean
  multiple?: boolean
  clearable?: boolean
  loading?: boolean
  disabled?: boolean
  inputProps?: Record<string, string>
  labelProps?: Record<string, string>
}>()

defineEmits(['search', 'update'])

const model = reactive(props.model)
const validation = reactiveComputed(() => ({
  [props.path]: model.errors[props.path] !== undefined ? 'error' : undefined,
}))

const disabled = computed(() => props.disabled || model.processing)
const loading = computed(() => props.loading || model.processing)
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
    class="items-start"
    :path="props.path" :label="props.label"
    :label-props="labelProps"
    :validation-status="validation[props.path]"
    :feedback="model.errors[props.path]"
  >
    <n-select
      v-model:value="model[props.path]"
      filterable remote
      :clearable="props.clearable"
      :placeholder="props.placeholder"
      :input-props="inputProps"
      :options="props.options"
      :multiple="props.multiple"
      :loading="loading"
      :disabled="disabled"
      @search="$emit('search', $event)"
      @update:value="$emit('update', $event)"
    />
  </n-form-item>
</template>

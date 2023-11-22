<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { ListType } from 'naive-ui/es/upload/src/interface'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: keyof GenericData
  model: InertiaForm<GenericData>
  accept: string
  listType: ListType
  label?: string
  max?: number
  loading?: boolean
  disabled?: boolean
  inputProps?: Record<string, string>
  labelProps?: Record<string, string>
}>()

const model = reactive(props.model)
const validation = reactiveComputed(() => ({
  [props.path]: model.errors[props.path] !== undefined ? 'error' : undefined,
}))

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

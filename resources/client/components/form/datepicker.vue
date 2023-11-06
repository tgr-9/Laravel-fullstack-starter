<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: string
  label: string
  placeholder?: string
  autofocus?: boolean
  disabled?: boolean
  model: InertiaForm<GenericData>
  validation: Record<string, 'error' | undefined>
}>()

const model = reactive(props.model)
const validation = reactive(props.validation)
const disabled = computed(() => props.disabled || model.processing)

/**
 * Make sure any value passed to the `n-date-picker` component is a unix timestamp
 */
watch(() => model[props.path], (value) => {
  if (value !== null)
    model[props.path] = ensureNumeric(value)
})

function ensureNumeric(value: string | number | Date): number {
  if (value instanceof Date)
    return value.getTime()

  return new Date(value).getTime()
}
</script>

<template>
  <n-form-item
    :path="props.path" :label="props.label"
    :label-props="{ for: props.path }"
    :validation-status="validation[props.path]"
    :feedback="model.errors[props.path]"
  >
    <n-date-picker
      v-model:value="model[props.path]"
      :placeholder="props.placeholder"
      :input-props="{ id: props.path, name: props.path }"
      :loading="model.processing"
      :disabled="disabled"
      :autofocus="props.autofocus"
    />
  </n-form-item>
</template>

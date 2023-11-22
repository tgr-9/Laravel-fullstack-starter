<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: keyof GenericData
  model: InertiaForm<GenericData>
  label?: string
  placeholder?: string
  autofocus?: boolean
  disabled?: boolean
  inputProps?: Record<string, string>
  labelProps?: Record<string, string>
}>()

const model = reactive(props.model)
const validation = reactiveComputed(() => ({
  [props.path]: model.errors[props.path] !== undefined ? 'error' : undefined,
}))

const disabled = computed(() => props.disabled || model.processing)
const labelProps = computed(() => ({ for: props.path, ...(props.labelProps || {}) }))
const inputProps = computed(() => ({
  ...(props.inputProps || {}),
  autocomplete: props.path,
  name: props.path,
  id: props.path,
}))

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
    class="items-start"
    :path="props.path" :label="props.label"
    :label-props="labelProps"
    :validation-status="validation[props.path]"
    :feedback="model.errors[props.path]"
  >
    <n-date-picker
      v-model:value="model[props.path]"
      :placeholder="props.placeholder"
      :input-props="inputProps"
      :loading="model.processing"
      :disabled="disabled"
      :autofocus="props.autofocus"
    />
  </n-form-item>
</template>

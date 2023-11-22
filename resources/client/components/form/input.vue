<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { InputProps } from 'naive-ui/lib/input'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: keyof GenericData
  model: InertiaForm<GenericData>
  label?: string
  type?: InputProps['type']
  placeholder?: string
  autofocus?: boolean
  disabled?: boolean
  loading?: boolean
  inputProps?: Record<string, string>
  labelProps?: Record<string, string>
}>()

defineEmits(['update'])

const model = reactive(props.model)
const validation = reactiveComputed(() => ({
  [props.path]: model.errors[props.path] !== undefined ? 'error' : undefined,
}))

const disabled = computed(() => props.disabled || model.processing)
const loading = computed(() => props.loading || model.processing)
const showPasswordOn = computed(() => props.type === 'password' ? 'mousedown' : undefined)
const labelProps = computed(() => ({ for: props.path, ...(props.labelProps || {}) }))
const inputProps = computed(() => ({
  autocomplete: props.path,
  ...(props.inputProps || {}),
  name: props.path,
  id: props.path,
}))

/**
 * Make sure any value passed to the `n-input` component is a string
 */
watch(() => model[props.path], (value) => {
  if (typeof value === 'number')
    model[props.path] = value.toString()
})
</script>

<template>
  <n-form-item
    class="items-start"
    :path="props.path" :label="props.label"
    :label-props="labelProps"
    :validation-status="validation[props.path]"
    :feedback="model.errors[props.path]"
  >
    <n-input
      v-model:value="model[props.path]"
      :placeholder="props.placeholder"
      :show-password-on="showPasswordOn"
      :type="props.type"
      :input-props="inputProps"
      :loading="loading"
      :disabled="disabled"
      :autofocus="props.autofocus"
      @update:value="$emit('update', $event)"
    />
  </n-form-item>
</template>

<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: keyof GenericData
  model: InertiaForm<GenericData>
  options: RadioOption[]
  label?: string
  placeholder?: string
  disabled?: boolean
  labelProps?: Record<string, string>
}>()

export interface RadioOption {
  value: string | number | boolean
  label: string
}

const model = reactive(props.model)
const validation = reactiveComputed(() => ({
  [props.path]: model.errors[props.path] !== undefined ? 'error' : undefined,
}))

const disabled = computed(() => props.disabled || model.processing)
const labelProps = computed(() => ({ for: props.path, ...(props.labelProps || {}) }))
</script>

<template>
  <n-form-item
    class="items-start"
    :path="props.path" :label="props.label"
    :label-props="labelProps"
    :validation-status="validation[props.path]"
    :feedback="model.errors[props.path]"
  >
    <n-radio-group v-model:value="model[props.path]" :name="props.path">
      <template v-for="opt of props.options" :key="opt.value">
        <n-radio :value="opt.value" :disabled="disabled" :label="opt.label" />
      </template>
    </n-radio-group>
  </n-form-item>
</template>

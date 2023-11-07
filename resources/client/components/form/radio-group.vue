<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: keyof GenericData
  label?: string
  placeholder?: string
  disabled?: boolean
  model: InertiaForm<GenericData>
  validation: Record<keyof GenericData, 'error' | undefined>
  options: RadioOption[]
}>()

export interface RadioOption {
  value: string | number | boolean
  label: string
}

const model = reactive(props.model)
const validation = reactive(props.validation)
const disabled = computed(() => props.disabled || model.processing)
</script>

<template>
  <n-form-item
    :path="props.path" :label="props.label"
    :label-props="{ for: props.path }"
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

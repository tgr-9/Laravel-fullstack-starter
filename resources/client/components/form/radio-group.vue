<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: string
  label: string
  options: RadioOption[]
  placeholder?: string
  model: InertiaForm<GenericData>
  validation: Record<string, 'error' | undefined>
}>()

export interface RadioOption {
  value: string | number | boolean
  label: string
}

const model = reactive(props.model)
const validation = reactive(props.validation)
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
        <n-radio
          :value="opt.value"
          :loading="model.processing"
          :disabled="model.processing"
        >
          {{ opt.label }}
        </n-radio>
      </template>
    </n-radio-group>
  </n-form-item>
</template>

<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: string
  label: string
  placeholder?: string
  autofocus?: boolean
  disabled?: boolean
  loading?: boolean
  model: InertiaForm<GenericData>
  validation: Record<string, 'error' | undefined>
}>()

defineEmits(['update'])

const model = reactive(props.model)
const validation = reactive(props.validation)
const disabled = computed(() => props.disabled || model.processing)
const loading = computed(() => props.loading || model.processing)

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
    :path="props.path" :label="props.label"
    :label-props="{ for: props.path }"
    :validation-status="validation[props.path]"
    :feedback="model.errors[props.path]"
  >
    <n-input
      v-model:value="model[props.path]"
      :placeholder="props.placeholder"
      :input-props="{ id: props.path, name: props.path }"
      :loading="loading"
      :disabled="disabled"
      :autofocus="props.autofocus"
      @update:value="$emit('update', $event)"
    />
  </n-form-item>
</template>

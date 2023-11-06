<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { ListType } from 'naive-ui/es/upload/src/interface'
import type { GenericData } from '~/types/api'

const props = defineProps<{
  path: string
  label: string
  accept: string
  listType: ListType
  max: number
  model: InertiaForm<GenericData>
  validation: Record<string, 'error' | undefined>
}>()

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
    <n-upload
      v-model:value="model[props.path]"
      :list-type="props.listType"
      :accept="props.accept"
      :max="props.max"
      :input-props="{ id: props.path, name: props.path }"
      :loading="model.processing"
      :disabled="model.processing"
    />
  </n-form-item>
</template>

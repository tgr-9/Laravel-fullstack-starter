<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { SelectOption } from 'naive-ui'
import { useNusaStore } from '~/store/nusa'
import type { Addressable } from '~/utils/nusa'

const props = defineProps<{
  path: keyof Addressable
  label: string
  model: InertiaForm<Addressable>
}>()

const emit = defineEmits(['update'])

const nusa = useNusaStore()
const model = reactive(props.model)
const options = computed<SelectOption[]>(() => nusa.provinces.map(i => ({
  label: i.name,
  value: i.code,
})))

onMounted(async () => {
  await nusa.fetchProvinces()
})

watch(() => model[props.path], (value) => {
  nusa.province(typeof value === 'string' ? +value : value)
})

function update(value: number) {
  nusa.province_code = value
  emit('update', value)
}
</script>

<template>
  <form-select
    placeholder="Pilih Provinsi"
    class="w-full md:w-1/2 lg:w-1/3 items-start"
    :path="props.path" :label="props.label"
    :model="model" :options="options"
    @update="update"
  />
</template>

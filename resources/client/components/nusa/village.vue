<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { SelectOption } from 'naive-ui'
import { useNusaStore } from '~/store/nusa'
import type { Addressable, District } from '~/utils/nusa'

const props = defineProps<{
  path: keyof Addressable
  label: string
  districtCode?: District['code'] | null
  model: InertiaForm<Addressable>
  validation: Record<keyof Addressable, 'error' | undefined>
}>()

const emit = defineEmits(['update'])

const nusa = useNusaStore()
const model = reactive(props.model)
const validation = reactive(props.validation)
const loading = toRef(model.processing)
const disabled = computed(() => props.districtCode !== undefined)
const keyword = ref<string | undefined>()
const debouncedKeyword = refDebounced(keyword)
const options = computed<SelectOption[]>(() => nusa.villages.map(i => ({
  label: i.name,
  value: i.code,
})))

watch(() => model[props.path], async (value) => {
  await nusa.village(typeof value === 'string' ? +value : value)
})

watchEffect(async () => {
  if (props.districtCode !== null) {
    loading.value = true
    await nusa.fetchVillages({
      search: debouncedKeyword,
      districtCode: props.districtCode,
    })
  }

  loading.value = false
})

function update(value: number) {
  nusa.village_code = value
  nusa.postal_code = nusa.villages.find(v => v.code === value)?.postal_code || null
  keyword.value = undefined
  emit('update', value)
}

function search(value: string) {
  keyword.value = value
}
</script>

<template>
  <form-select
    placeholder="Pilih Desa/Kelurahan"
    clearable :loading="loading" :disabled="disabled"
    :path="props.path" :label="props.label" :options="options"
    :model="model" :validation="validation"
    @search="search"
    @update="update"
  />
</template>

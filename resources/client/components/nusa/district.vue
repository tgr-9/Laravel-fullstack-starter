<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import type { SelectOption } from 'naive-ui'
import { useNusaStore } from '~/store/nusa'
import type { Addressable, Regency } from '~/utils/nusa'

const props = defineProps<{
  path: keyof Addressable
  label: string
  regencyCode?: Regency['code'] | null
  model: InertiaForm<Addressable>
  validation: Record<keyof Addressable, 'error' | undefined>
}>()

const emit = defineEmits(['update'])

const nusa = useNusaStore()
const model = reactive(props.model)
const validation = reactive(props.validation)
const loading = toRef(model.processing)
const disabled = computed(() => props.regencyCode !== undefined)
const keyword = ref<string | undefined>()
const debouncedKeyword = refDebounced(keyword)
const options = computed<SelectOption[]>(() => nusa.districts.map(i => ({
  label: i.name,
  value: i.code,
})))

watch(
  () => model[props.path],
  async (value) => {
    await nusa.district(typeof value === 'string' ? +value : value)
  },
)

watchEffect(async () => {
  if (props.regencyCode !== null) {
    loading.value = true
    await nusa.fetchDistricts({
      search: debouncedKeyword,
      regencyCode: props.regencyCode,
    })
  }

  loading.value = false
})

function update(value: number) {
  nusa.district_code = value
  keyword.value = undefined
  emit('update', value)
}

function search(value: string) {
  keyword.value = value
}
</script>

<template>
  <form-select
    placeholder="Pilih Kecamatan"
    clearable :loading="loading" :disabled="disabled"
    :path="props.path" :label="props.label" :options="options"
    :model="model" :validation="validation"
    @search="search"
    @update="update"
  />
</template>

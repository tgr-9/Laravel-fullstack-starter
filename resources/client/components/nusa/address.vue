<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import { AxiosError } from 'axios'
import { useNusaStore } from '~/store/nusa'
import type { Addressable } from '~/utils/nusa'

const props = defineProps<{
  model: InertiaForm<Addressable>
  validation: Record<keyof Addressable, 'error' | undefined>
}>()

const nusa = useNusaStore()
const model = reactive(props.model)
const validation = reactive(props.validation)
const fetchingPostalCode = ref<boolean>(false)

async function updatePostalCode(value: number) {
  if (value.toString().length !== 5)
    return

  fetchingPostalCode.value = true
  model.clearErrors('postal_code')

  try {
    const village = await nusa.postalCode(value)

    if (!village) {
      model.setError('postal_code', 'Invalid postal code')
      return
    }

    model.province_code = village.province_code
    model.regency_code = village.regency_code
    model.district_code = village.district_code
    model.village_code = village.code
  }
  catch (err) {
    if (err instanceof AxiosError) {
      model.setError('postal_code', err.response?.data?.message)
      return
    }

    console.error(err)
  }
  finally {
    fetchingPostalCode.value = false
  }
}

function updateProvince() {
  model.regency_code = null
  model.district_code = null
  model.village_code = null
  model.postal_code = null
}

function updateRegency() {
  model.district_code = null
  model.village_code = null
  model.postal_code = null
}

function updateDistrict() {
  model.village_code = null
  model.postal_code = null
}

function updateVillage() {
  model.postal_code = nusa.postal_code!
}
</script>

<template>
  <form-input
    path="address_line" label="Alamat Lengkap"
    placeholder="Alamat Jalan/Gang/Blok dan Nomor Rumah"
    :model="model" :validation="validation"
  />

  <div class="flex gap-3 w-full">
    <form-input
      path="rt" label="RT"
      placeholder="000"
      class="w-full md:w-1/3 lg:w-auto items-start"
      :model="model" :validation="validation"
    />

    <form-input
      path="rw" label="RW"
      placeholder="000"
      class="w-full md:w-1/3 lg:w-auto items-start"
      :model="model" :validation="validation"
    />

    <form-input
      path="postal_code" label="Kode POS"
      placeholder="12345"
      class="w-full md:w-1/3 lg:w-auto items-start"
      :model="model" :validation="validation"
      :loading="fetchingPostalCode"
      @update="updatePostalCode"
    />
  </div>

  <div class="flex gap-3 w-full">
    <nusa-province
      path="province_code" label="Provinsi"
      class="w-full md:w-1/2 lg:w-1/3 items-start"
      :model="model" :validation="validation"
      @update="updateProvince"
    />

    <nusa-regency
      path="regency_code" label="Kota/Kabupaten"
      class="w-full md:w-1/2 lg:w-1/3 items-start"
      :province-code="model.province_code"
      :model="model" :validation="validation"
      @update="updateRegency"
    />
  </div>

  <div class="flex gap-3 w-full">
    <nusa-district
      path="district_code" label="Kecamatan"
      class="w-full md:w-1/2 lg:w-1/3 items-start"
      :regency-code="model.regency_code"
      :model="model" :validation="validation"
      @update="updateDistrict"
    />

    <nusa-village
      path="village_code" label="Kelurahan"
      class="w-full md:w-1/2 lg:w-1/3 items-start"
      :district-code="model.district_code"
      :model="model" :validation="validation"
      @update="updateVillage"
    />
  </div>
</template>

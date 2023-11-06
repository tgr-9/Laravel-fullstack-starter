// this is a state management for vue 3 using pinia
// it is to handle administrative region database
// using creasico/laravel-nusa

import { defineStore } from 'pinia'
import type { MaybeRef } from 'vue'
import type { Addressable, District, Province, Regency, Village } from '~/utils/nusa'

interface NusaState extends Partial<Addressable> {
  /** Current available provinces */
  provinces: Province[]
  /** Current available regencies */
  regencies: Regency[]
  /** Current available districts */
  districts: District[]
  /** Current available villages */
  villages: Village[]
}

interface FetchNusaParams {
  search?: MaybeRef<string | undefined>
}

export interface FetchRegenciesParams extends FetchNusaParams {
  provinceCode?: MaybeRef<Province['code'] | undefined>
}

export interface FetchDistrictsParams extends FetchNusaParams {
  regencyCode?: MaybeRef<Regency['code'] | undefined>
}

export interface FetchVillagesParams extends FetchNusaParams {
  districtCode?: MaybeRef<District['code'] | undefined>
}

export const useNusaStore = defineStore('nusa', {
  state: (): NusaState => ({
    provinces: [],
    regencies: [],
    districts: [],
    villages: [],
    province_code: null,
    regency_code: null,
    district_code: null,
    village_code: null,
    postal_code: null,
  }),
  persist: true,
  actions: {
    $reset() {
      this.province_code = null
      this.regency_code = null
      this.district_code = null
      this.village_code = null
      this.postal_code = null
    },

    async postalCode(code: Village['postal_code'] | null) {
      if (!code)
        return null

      const village = await getVillageByPostalCode(code)

      if (village) {
        this.postal_code = code

        return village
      }

      return null
    },

    async province(code: Province['code'] | null) {
      this.province_code = code
    },

    async fetchProvinces({ search }: FetchNusaParams = {}) {
      this.provinces = await getProvinces(toRef(search).value)

      return this.provinces
    },

    async regency(code: Regency['code'] | null) {
      if (code && !this.regencies.find(i => i.code === code)) {
        const regency = await getRegency(code)

        if (regency)
          this.regencies.push(regency)
      }

      this.regency_code = code
    },

    async fetchRegencies({ search, provinceCode }: FetchRegenciesParams = {}) {
      this.regencies = await getRegencies(toRef(search).value, toRef(provinceCode).value)

      return this.regencies
    },

    async district(code: District['code'] | null) {
      if (code && !this.districts.find(i => i.code === code)) {
        const district = await getDistrict(code)

        if (district)
          this.districts.push(district)
      }

      this.district_code = code
    },

    async fetchDistricts({ search, regencyCode }: FetchDistrictsParams = {}) {
      this.districts = await getDistricts(toRef(search).value, toRef(regencyCode).value)

      return this.districts
    },

    async village(code: Village['code'] | null) {
      if (code && !this.villages.find(i => i.code === code)) {
        const village = await getVillage(code)

        if (village)
          this.villages.push(village)
      }

      this.village_code = code
    },

    async fetchVillages({ search, districtCode }: FetchVillagesParams = {}) {
      this.villages = await getVillages(toRef(search).value, toRef(districtCode).value)

      return this.villages
    },
  },
})

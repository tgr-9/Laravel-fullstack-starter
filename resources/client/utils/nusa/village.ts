import type { CollectionResponse, ItemResponse } from '~/types/api'

/**
 * Represents a village object.
 */
export interface Village {
  code: number
  name: string
  district_code: number
  regency_code: number
  province_code: number
  postal_code?: number
}

/**
 * Represents a api response for village resource collection.
 */
export type VillagesResponse = CollectionResponse<Village>

/**
 * Represents a api response for village resource item.
 */
export type VillageResponse = ItemResponse<Village>

/**
 * Retrieves villages based on district code or search query.
 * @param districtCode - The district code to filter villages by district.
 * @param search - The search query to filter villages by name.
 * @returns A Promise that resolves to an array of Village objects.
 */
export async function getVillages(search?: string, districtCode?: number) {
  const { data } = districtCode
    ? await axios.get<VillagesResponse>(route('nusa.districts.villages', { district: districtCode, search }))
    : await axios.get<VillagesResponse>(route('nusa.villages.index', { search }))

  return data.data
}

/**
 * Retrieves village based on village code.
 * @param village Village code.
 */
export async function getVillage(village: number) {
  const { data } = await axios.get<VillageResponse>(route('nusa.villages.show', { village }))

  return data.data
}

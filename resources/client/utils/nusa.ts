import type { VillagesResponse } from './nusa/village'

export * from './nusa/province'
export * from './nusa/district'
export * from './nusa/regency'
export * from './nusa/village'

export interface Addressable {
  village_code: number | null
  district_code: number | null
  regency_code: number | null
  province_code: number | null
  postal_code: string | number | null
}

/**
 * Retrieves villages based on `postalCode`.
 * @param postalCode The village postal code.
 * @returns A Promise that resolves to an array of Village objects.
 */
export async function getVillageByPostalCode(postalCode: number) {
  const { data } = await axios.get<VillagesResponse>(route('nusa.villages.index', { postal_code: postalCode }))

  return data.data[0] || null
}

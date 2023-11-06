import type { CollectionResponse, ItemResponse } from '~/types/api'

/**
 * Represents a regency object.
 */
export interface Regency {
  code: number
  name: string
  province_code: number
}

/**
 * Represents a api response for regency resource collection.
 */
export type RegenciesResponse = CollectionResponse<Regency>

/**
 * Represents a api response for regency resource item.
 */
export type RegencyResponse = ItemResponse<Regency>

/**
 * Retrieves regencies based on province code or search query.
 * @param provinceCode - The province code to filter regencies by province.
 * @param search - The search query to filter regencies by name.
 * @returns A Promise that resolves to an array of Regency objects.
 */
export async function getRegencies(search?: string, provinceCode?: number) {
  const { data } = provinceCode
    ? await axios.get<RegenciesResponse>(route('nusa.provinces.regencies', { province: provinceCode, search }))
    : await axios.get<RegenciesResponse>(route('nusa.regencies.index', { search }))

  return data.data
}

/**
 * Retrieves regency based on regency code.
 * @param regency Regency code.
 */
export async function getRegency(regency: number) {
  const { data } = await axios.get<RegencyResponse>(route('nusa.regencies.show', { regency }))

  return data.data
}

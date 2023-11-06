import type { CollectionResponse, ItemResponse } from '~/types/api'

/**
 * Represents a district object.
 */
export interface District {
  code: number
  name: string
  regency_code: number
  province_code: number
}

/**
 * Represents a api response for district resource collection.
 */
export type DistrictsResponse = CollectionResponse<District>

/**
 * Represents a api response for district resource item.
 */
export type DistrictResponse = ItemResponse<District>

/**
 * Retrieves districts based on regency code or search query.
 * @param regencyCode - The regency code to filter districts by regency.
 * @param search - The search query to filter districts by name.
 * @returns A Promise that resolves to an array of District objects.
 */
export async function getDistricts(search?: string, regencyCode?: number) {
  const { data } = regencyCode
    ? await axios.get<DistrictsResponse>(route('nusa.regencies.districts', { regency: regencyCode, search }))
    : await axios.get<DistrictsResponse>(route('nusa.districts.index', { search }))

  return data.data
}

/**
 * Retrieves district based on district code.
 * @param district District code.
 */
export async function getDistrict(district: number) {
  const { data } = await axios.get<DistrictResponse>(route('nusa.districts.show', { district }))

  return data.data
}

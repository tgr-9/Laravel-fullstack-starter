import type { CollectionResponse, ItemResponse } from '~/types/api'

/**
 * Represents a province object.
 */
export interface Province {
  code: number
  name: string
}

/**
 * Represents a api response for province resource collection.
 */
export type ProvincesResponse = CollectionResponse<Province>

/**
 * Represents a api response for province resource item.
 */
export type ProvinceResponse = ItemResponse<Province>

/**
 * Retrieves provinces based on search query or province code.
 * @param search - The search query to filter provinces by name.
 * @param code - The province code to filter provinces by code.
 * @returns A Promise that resolves to an array of Province objects.
 */
export async function getProvinces(search?: string, code?: number) {
  const { data } = await axios.get<ProvincesResponse>(route('nusa.provinces.index', { search, code }))

  return data.data
}

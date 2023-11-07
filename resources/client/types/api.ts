export type GenericData = Record<string, any>

interface BaseResponse {
  meta: Record<string, unknown>
  links?: Record<string, unknown>
}

export interface ItemResponse<T = GenericData> extends BaseResponse {
  data: T
}

export interface CollectionResponse<T = GenericData> extends BaseResponse {
  current_page: number
  last_page: number
  data: T[]
  per_page: number
  total: number
}

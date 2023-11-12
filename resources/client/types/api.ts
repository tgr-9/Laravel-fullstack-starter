export type GenericData = Record<string, any>

interface BaseResponse {
  meta: Record<string, unknown>
  links?: Record<string, unknown>
}

export interface ItemResponse<T = GenericData> extends BaseResponse {
  data: T
}

export interface CollectionResponse<T = GenericData> extends BaseResponse {
  data: T[]
  meta: {
    current_page: number
    from: number
    last_page: number
    per_page: number
    to: number
    total: number
  }
}

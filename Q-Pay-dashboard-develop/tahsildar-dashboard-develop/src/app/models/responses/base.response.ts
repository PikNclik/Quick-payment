export interface BaseResponse<T> {
  message: string;
  status: boolean;
  data: T;
  status_code: number;
}

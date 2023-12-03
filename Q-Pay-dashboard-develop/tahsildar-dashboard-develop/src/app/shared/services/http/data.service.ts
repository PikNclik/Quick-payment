import { HttpClient } from '@angular/common/http';
import {catchError, map, Observable} from 'rxjs';
import { CommonDataService } from './common-data.service';
import { BaseResponse } from 'src/app/models/responses/base.response';

export class DataService extends CommonDataService {
  constructor(
    endPoint: string,
    protected http: HttpClient,
    adminPrefix = true,
  ) {
    super(endPoint, adminPrefix);
  }

  get<T>(resourceName: string = '', queryParams?: any, headers?: any): Observable<T> {
    return this.http
      .get<BaseResponse<T>>(this.getFullUrl(resourceName), {
        params: queryParams,
        headers,
      })
      .pipe(map(this.emitData), catchError(this.handleError));
  }

  download(resourceName: string = '', filename: string, ext: string, queryParams?: any, headers?: any): Observable<any> {
    return this.http
      .get(this.getFullUrl(resourceName), {
        params: queryParams,
        headers,
        observe: 'response',
        responseType: 'blob',
      })
      .pipe(map(res => this.saveFile(res, filename, ext)), catchError(this.handleError));
  }

  post<T>(resourceName: string, resource: any = null): Observable<T> {
    return this.http
      .post<BaseResponse<T>>(this.getFullUrl(resourceName), resource)
      .pipe(map(this.emitData), catchError(this.handleError));
  }

  put<T>(resourceName: string, resource: any = null): Observable<T> {
    return this.http
      .put<BaseResponse<T>>(this.getFullUrl(resourceName), resource)
      .pipe(map(this.emitData), catchError(this.handleError));
  }

  patch<T>(resourceName: string, resource: any = null): Observable<T> {
    return this.http
      .patch<BaseResponse<T>>(this.getFullUrl(resourceName), resource)
      .pipe(map(this.emitData), catchError(this.handleError));
  }

  delete(resourceName: string): Observable<void> {
    return this.http
      .delete<BaseResponse<any>>(this.getFullUrl(resourceName))
      .pipe(
        map(this.emitData),
        catchError(this.handleError)
      );
  }
}

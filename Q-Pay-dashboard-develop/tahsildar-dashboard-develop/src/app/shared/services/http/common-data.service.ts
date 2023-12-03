import {HttpErrorResponse, HttpResponse} from '@angular/common/http';
import * as moment from 'moment';
import { Observable, throwError } from 'rxjs';
import { AppError } from 'src/app/models/responses/app-error';
import { BaseResponse } from 'src/app/models/responses/base.response';
import { environment } from 'src/environments/environment';
import { saveAs } from 'file-saver';

export class CommonDataService {
  constructor(
    private endPoint: string,
    private adminPrefix = true,
  ) { }

  protected getFullUrl(resourceName: string) {
    let url = `${environment.apiUrl}${this.adminPrefix ? '/admin' : ''}`;
    let endpoint = this.endPoint;
    if (endpoint) {
      url = `${url}/${endpoint}`;
    }
    if (resourceName) {
      url = `${url}/${resourceName}`;
    }
    return url;
  }

  protected emitData<T>(response: BaseResponse<T>): T {
    return response.data;
  }

  protected saveFile(res: HttpResponse<Blob>, filename: string, ext: string): void {
    if(res && res.body instanceof Blob) {
      saveAs(res.body, `${filename}.${ext}`)
    }
  }

  protected handleError(error: Error): Observable<never> {
    if (error instanceof HttpErrorResponse) {
      return throwError(() => new AppError(error.statusText));
    }
    return throwError(() => new AppError(error.message));
  }

  public parseToFormData(object: any): FormData {
    const keys = Object.keys(object);
    const formData = new FormData();

    for (const key of keys) {
      if (object[key] instanceof moment) object[key] = object[key].format();

      if (object[key] instanceof Date) {
        object[key] = moment(object[key]).toISOString();
      }

      if (Array.isArray(object[key])) {
        const list = [...object[key]];
        for (let i = 0; i < list.length; i++) {
          formData.append(`${key}[${i}]`, list[i] instanceof Object ? JSON.stringify(list[i]) : list[i]);
        }
        continue;
      }

      if (object[key] !== null && typeof object[key] !== 'undefined') {
        formData.append(key, object[key]);
      }
    }

    return formData;
  }
}

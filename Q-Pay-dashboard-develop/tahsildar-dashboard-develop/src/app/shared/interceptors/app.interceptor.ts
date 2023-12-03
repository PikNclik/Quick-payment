import {
  HttpErrorResponse,
  HttpEvent,
  HttpHandler,
  HttpInterceptor,
  HttpRequest,
  HttpResponse,
} from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, catchError, tap } from 'rxjs';
import { AuthService } from '../services/auth.service';

@Injectable()
export class AppHttpInterceptor implements HttpInterceptor {
  constructor(private router: Router, private authService: AuthService) { }
  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    if (request.url.includes('http')) {
      // http request
      if (this.authService.getUser()) {
        request = request.clone({
          setHeaders: {
            Authorization: `Bearer ${this.authService.getAuthToken()}`,
          },
        });
      }
      return next.handle(request).pipe(tap((event: HttpEvent<any>) => {
        if (event instanceof HttpResponse) {
          // handle un-success response
          if (event.body?.status == false) {
            const errors = event.body?.errors;
            let message = event.body?.message;
            // try get message from validation error
            if (Array.isArray(errors) && errors.length > 0) {
              const error = errors[0];
              if (Array.isArray(error)) {
                message = error[0];
              }
            }
            const error = {
              status: event.body?.status_code,
              error: message,
              statusText: message,
              statusCode: event.body?.status_code,
            };
            throw this.handleError(new HttpErrorResponse({ error }));
          }
        }
      })).pipe(catchError((error: HttpErrorResponse) => { throw this.handleError(error) }));
    } else {
      // assets request
      return next.handle(request);
    }
  }

  private handleError(response: HttpErrorResponse): HttpErrorResponse {
    const statusCode = response.status;
    if (statusCode === 401 || statusCode === 403) {
      this.authService.removeUser();
      this.router.navigateByUrl(`/login`);
    }
    const errorResponse = typeof response.error == 'string' ? response : response.error;
    return new HttpErrorResponse(errorResponse);
  }
}

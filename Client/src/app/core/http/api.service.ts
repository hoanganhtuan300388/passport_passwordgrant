import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { FormGroup } from '@angular/forms';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

import { environment } from '../../../environments/environment';
import { TokenService } from '../../core/services/token.service';

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  public url: string = environment.apiURL;

  constructor(
    private _http: HttpClient,
    private _router: Router,
    private _tokenService: TokenService
  ) { }

  public get(api: string, params: any = {}): Observable<any> {
    return this._http.get<any>(this.getApiUrl(api)).pipe(
      map((response: any) => {
        console.log('response.output', response.output);
        return response.output;
      }),
      catchError((error: HttpErrorResponse) => this.handleError(error))
    );
  }

  public post(api: string, form: FormGroup): Observable<any> {
    let body = form ? form.value : {};
    return this._http.post<any>(this.getApiUrl(api), body).pipe(
      map((response: any) => {
        console.log('response.output', response.output);
        return response.output;
      }),
      catchError((error: HttpErrorResponse) => this.handleError(error, form))
    );
  }

  public put(api: string, form: FormGroup): Observable<any> {
    let body = form ? form.value : {};
    return this._http.put<any>(this.getApiUrl(api), body).pipe(
      map((response: any) => {
        console.log('response.output', response.output);
        return response.output;
      }),
      catchError((error: HttpErrorResponse) => this.handleError(error, form))
    );
  }

  public delete() {

  }

  private getApiUrl(api: string): string {
    return this.url + api;
  }

  private handleError(error: HttpErrorResponse, form: FormGroup = null) {
    if (error.error instanceof ErrorEvent) {
      console.log('An error occurred:', error.error.message);
    } else {
      //bad request
      if (error.status === 400) {
        if (form && error.error.errors) {
          for (const fieldError in error.error.errors) {
              form.controls[fieldError].setErrors({'error': error.error.errors[fieldError][0]});
          }
        }
      } 
      //login field
      else if (error.status === 401) { 
        form.controls['username'].setErrors({'error': error.error.message});
        form.controls['password'].setErrors({'error': error.error.message});
      } 
      //not authen token
      else if (error.status === 498 || error.status === 499) {
        this._tokenService.deleteToken();
        this._router.navigate(['/auth/login']);
      } else {

      }
      
      console.log('error infomation', error);
    }

    return throwError('Something bad happened; please try again later.');
  }

}

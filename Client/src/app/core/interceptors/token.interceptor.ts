import { Injectable } from '@angular/core';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest, HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";

import { TokenService } from '../services/token.service';
import { Token } from '../models/token';

@Injectable({
  providedIn: 'root'
})
export class TokenInterceptor implements HttpInterceptor {

  constructor(
    public tokenService: TokenService
  ) { }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    let httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    };

    if (this.tokenService.getToken()) {
      let token: Token = this.tokenService.getToken();
      httpOptions.headers = httpOptions.headers.set('Authorization', `${token.token_type} ${token.access_token}`);
    }

    request = request.clone(httpOptions);
    return next.handle(request);
  }

}

import { Injectable } from '@angular/core';

import { Token } from '../models/token';

@Injectable({
  providedIn: 'root'
})
export class TokenService {

  constructor() { }

  public getToken(): Token {
    return JSON.parse(localStorage.getItem('token'));
  }

  public setToken(token: Token) {
    localStorage.setItem('token', JSON.stringify(token));
  }

  public deleteToken()
  {
    localStorage.removeItem('token');
  }

}

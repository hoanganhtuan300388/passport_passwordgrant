import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';
import { Router, CanActivate } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class MemberAuthGuard implements CanActivate {

  constructor(private _route: Router) { }

  canActivate(): boolean {
    if (localStorage.getItem('token') === null) {
      this._route.navigate(['/auth/login']);
    }
    
    return true;
  }

}

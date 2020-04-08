import { Injectable } from '@angular/core';
import { HttpRequest } from "@angular/common/http";
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LoaderService {

  public isLoading = new Subject<boolean>();

  constructor() { }

  show(request: HttpRequest<any>) {
    if (request.url.indexOf('message') === -1) {
      this.isLoading.next(true);
    }
  }

  hide(request: HttpRequest<any>) {
    if (request.url.indexOf('message') === -1) {
      this.isLoading.next(false);
    }
  }

}

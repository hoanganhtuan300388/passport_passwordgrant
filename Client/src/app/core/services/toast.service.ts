import { Injectable } from '@angular/core';
import { Observable, Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ToastService {

  public isToast = new Subject<boolean>();
  public message = new Subject<string>();

  constructor() { }

  show(message) {
    setTimeout(() => {
      this.message.next(message);
      this.isToast.next(true);

      setTimeout(() => {
        this.hide();
      }, 3000);
    }, 500);
  }

  hide() {
    this.message.next('');
    this.isToast.next(false);
  }

  getMessage(): Observable<any> {
    return this.message.asObservable();
  }

}

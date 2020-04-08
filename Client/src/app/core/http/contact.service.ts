import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { FormGroup } from '@angular/forms';

import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root'
})
export class ContactService {

  constructor(
    private _apiService: ApiService
  ) { }

  public getMessages(id: number): Observable<any> {
    return this._apiService.get('contact/' + id + '/message');
  }

  public sendMessage(id: number, sendMessageForm: FormGroup): Observable<any> {
    return this._apiService.post('contact/' + id + '/message', sendMessageForm);
  }

}

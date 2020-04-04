import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { FormGroup } from '@angular/forms';

import { ApiService } from './api.service';
import { Profile } from '../models/profile';
import { Member } from '../models/member';
import { MemberContact } from '../models/member-contact';
import { MemberSetting } from '../models/member-setting';

@Injectable({
  providedIn: 'root'
})
export class MemberService {

  constructor(
    private _apiService: ApiService
  ) { }

  public login(loginForm: FormGroup): Observable<any> 
  {
    return this._apiService.post('login', loginForm);
  }

  public logout(): Observable<any> 
  {
    return this._apiService.post('logout', null);
  }

  public register(registerForm: FormGroup): Observable<any> 
  {
    return this._apiService.post('register', registerForm);
  }

  public contact(): Observable<any>
  {
    return this._apiService.get('contact');
  }

  public profile(): Observable<Profile>
  {
    return this._apiService.get('profile');
  }

  public editMember(memberForm: FormGroup): Observable<Member>
  {
    return this._apiService.put('profile/member', memberForm);
  }

  public editContact(contactForm: FormGroup): Observable<MemberContact>
  {
    return this._apiService.put('profile/contact', contactForm);
  }

  public editSetting(settingForm: FormGroup): Observable<MemberSetting>
  {
    return this._apiService.put('profile/setting', settingForm);
  }

}

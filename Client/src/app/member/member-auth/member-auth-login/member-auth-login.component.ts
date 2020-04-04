import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

import { MemberService } from '../../../core/http/member.service';
import { TokenService } from '../../../core/services/token.service';
import { ToastService } from '../../../core/services/toast.service';

@Component({
  selector: 'app-member-auth-login',
  templateUrl: './member-auth-login.component.html',
  styleUrls: ['./member-auth-login.component.css']
})
export class MemberAuthLoginComponent implements OnInit {

  public loginForm: FormGroup;

  constructor(
    private _router: Router,
    private _formBuilder: FormBuilder,
    private _memberService: MemberService,
    private _tokenService: TokenService,
    private _toastService: ToastService
  ) { }

  ngOnInit() {
    this.buildLoginForm();
  }

  buildLoginForm() {
    this.loginForm = this._formBuilder.group({
      'username': ['', [Validators.required]],
      'password': ['', [Validators.required]]
    });
  }

  login() {
    if (this.loginForm.valid) {
      this._memberService.login(this.loginForm).subscribe((data) => {
        this._tokenService.setToken(data.token);
        this._router.navigate(['/contact']);
        this._toastService.show('Đăng nhập thành công!');
      });
    }
  }

}

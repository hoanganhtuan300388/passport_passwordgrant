import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

import { MemberService } from '../../../core/http/member.service';
import { TokenService } from '../../../core/services/token.service';
import { ToastService } from '../../../core/services/toast.service';

@Component({
  selector: 'app-member-auth-register',
  templateUrl: './member-auth-register.component.html',
  styleUrls: ['./member-auth-register.component.css']
})
export class MemberAuthRegisterComponent implements OnInit {

  public registerForm: FormGroup;

  constructor(
    private _router: Router,
    private _formBuilder: FormBuilder,
    private _memberService: MemberService,
    private _tokenService: TokenService,
    private _toastService: ToastService
  ) { }

  ngOnInit() {
    this.buildRegisterForm();
  }

  buildRegisterForm() {
    this.registerForm = this._formBuilder.group({
      'username': ['', [Validators.required]],
      'password': ['', [Validators.required]],
      'password_confirmation': ['', [Validators.required]],
      'name': ['', [Validators.required]],
      'email': ['', [Validators.required, Validators.email]]
    });
  }

  register() {
    if (this.registerForm.valid) {
      this._memberService.register(this.registerForm).subscribe((data) => {
        this._tokenService.setToken(data.token);
        this._router.navigate(['/contact']);
        this._toastService.show('Đăng ký thành viên thành công!');
      });
    }
  }

}

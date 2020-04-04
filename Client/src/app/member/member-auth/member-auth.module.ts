import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';

import { MemberAuthComponent } from './member-auth.component';
import { MemberAuthLoginComponent } from './member-auth-login/member-auth-login.component';
import { MemberAuthRegisterComponent } from './member-auth-register/member-auth-register.component';
import { MemberAuthForgotComponent } from './member-auth-forgot/member-auth-forgot.component';

const routes: Routes = [
  {
    path: 'auth',
    component: MemberAuthComponent,
    children: [
      {
        path: '',
        redirectTo: 'login',
        pathMatch: 'full'
      },
      {
        path: 'login',
        component: MemberAuthLoginComponent
      },
      {
        path: 'register',
        component: MemberAuthRegisterComponent
      },
      {
        path: 'forgot',
        component: MemberAuthForgotComponent
      }
    ]
  }
];

@NgModule({
  declarations: [
    MemberAuthComponent,
    MemberAuthLoginComponent,
    MemberAuthRegisterComponent,
    MemberAuthForgotComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    FormsModule,
    ReactiveFormsModule,
    BrowserModule,
    HttpClientModule
  ]
})
export class MemberAuthModule { }

import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { MemberAuthGuard } from '../core/guards/member-auth.guard';
import { MemberAuthModule } from './member-auth/member-auth.module';
import { MemberComponent } from './member.component';
import { MemberContactComponent } from './member-contact/member-contact.component';
import { MemberProfileComponent } from './member-profile/member-profile.component';
import { MemberChatComponent } from './member-chat/member-chat.component';
import { MemberSettingComponent } from './member-setting/member-setting.component';

const routes: Routes = [
  {
    path: '',
    component: MemberComponent,
    canActivate: [MemberAuthGuard],
    children: [
      {
        path: '',
        redirectTo: 'contact',
        pathMatch: 'full'
      },
      {
        path: 'contact',
        component: MemberContactComponent,
        data: {
          title: 'Liên Hệ',
          back: false
        }
      },
      {
        path: 'contact/:id',
        component: MemberChatComponent,
        data: {
          title: 'Trò Chuyện',
          back: true
        }
      },
      {
        path: 'profile',
        component: MemberProfileComponent,
        data: {
          title: 'Thông Tin Cá Nhân',
          back: false
        }
      },
      {
        path: 'profile/edit',
        component: MemberSettingComponent,
        data: {
          title: 'Sửa Thông Tin',
          back: true
        }
      }
    ]
  }
];

@NgModule({
  declarations: [
    MemberComponent,
    MemberContactComponent,
    MemberProfileComponent,
    MemberChatComponent,
    MemberSettingComponent
  ],
  imports: [
    MemberAuthModule,
    CommonModule,
    RouterModule.forChild(routes),
    FormsModule,
    ReactiveFormsModule
  ]
})
export class MemberModule { }

import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { HashLocationStrategy, LocationStrategy } from '@angular/common';

import { AppComponent } from './app.component';
import { MemberModule } from './member/member.module';
import { LoaderComponent } from './core/shared/loader/loader.component';
import { ToastComponent } from './core/shared/toast/toast.component';
import { LoaderService } from './core/services/loader.service';
import { LoaderInterceptor } from './core/interceptors/loader.interceptor';
import { TokenService } from './core/services/token.service';
import { TokenInterceptor } from './core/interceptors/token.interceptor';
import { ToastService } from './core/services/toast.service';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'contact',
    pathMatch: 'full'
  }
];

@NgModule({
  declarations: [
    AppComponent,
    LoaderComponent,
    ToastComponent
  ],
  imports: [
    BrowserModule,
    MemberModule,
    RouterModule.forRoot(routes),
    BrowserAnimationsModule
  ],
  providers: [
    { provide: LocationStrategy, useClass: HashLocationStrategy },
    LoaderService,
    { provide: HTTP_INTERCEPTORS, useClass: LoaderInterceptor, multi: true },
    TokenService,
    { provide: HTTP_INTERCEPTORS, useClass: TokenInterceptor, multi: true },
    ToastService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }

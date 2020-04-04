import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MemberAuthForgotComponent } from './member-auth-forgot.component';

describe('MemberAuthForgotComponent', () => {
  let component: MemberAuthForgotComponent;
  let fixture: ComponentFixture<MemberAuthForgotComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MemberAuthForgotComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MemberAuthForgotComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

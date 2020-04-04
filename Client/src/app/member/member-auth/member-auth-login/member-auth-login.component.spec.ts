import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MemberAuthLoginComponent } from './member-auth-login.component';

describe('MemberAuthLoginComponent', () => {
  let component: MemberAuthLoginComponent;
  let fixture: ComponentFixture<MemberAuthLoginComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MemberAuthLoginComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MemberAuthLoginComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

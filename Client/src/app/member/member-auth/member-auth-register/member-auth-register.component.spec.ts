import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MemberAuthRegisterComponent } from './member-auth-register.component';

describe('MemberAuthRegisterComponent', () => {
  let component: MemberAuthRegisterComponent;
  let fixture: ComponentFixture<MemberAuthRegisterComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MemberAuthRegisterComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MemberAuthRegisterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

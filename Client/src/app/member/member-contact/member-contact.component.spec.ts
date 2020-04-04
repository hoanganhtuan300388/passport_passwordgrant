import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MemberContactComponent } from './member-contact.component';

describe('MemberContactComponent', () => {
  let component: MemberContactComponent;
  let fixture: ComponentFixture<MemberContactComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MemberContactComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MemberContactComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

import { MemberService } from '../../core/http/member.service';
import { ToastService } from '../../core/services/toast.service';
import { Profile } from '../../core/models/profile';

@Component({
  selector: 'app-member-setting',
  templateUrl: './member-setting.component.html',
  styleUrls: ['./member-setting.component.css']
})
export class MemberSettingComponent implements OnInit {

  public memberForm: FormGroup;
  public contactForm: FormGroup;
  public settingForm: FormGroup;
  public profile: Profile;

  constructor(
    private _route: ActivatedRoute,
    private _formBuilder: FormBuilder,
    private _memberService: MemberService,
    private _toastService: ToastService
  ) { }

  ngOnInit() {
    this._route.params.subscribe(params => {
      if (params.profile) {
        this.profile = JSON.parse(params.profile);
      }
    });

    this.buildMemberForm();
    this.buildContactForm();
    this.buildSettingForm();
    this.loadDataMemberInfo();
    this.loadDataContactInfo();
    this.loadDataSettingInfo();
  }

  buildMemberForm() {
    this.memberForm = this._formBuilder.group({
      'id': [''],
      'name': ['', [Validators.required]],
      'city': [''],
      'country': [''],
      'birthday': [''],
      'gender': ['']
    });
  }

  buildContactForm() {
    this.contactForm = this._formBuilder.group({
      'email': ['', [Validators.required, Validators.email]],
      'mobile_phone': [''],
      'home_phone': [''],
      'office_phone': [''],
      'address1': [''],
      'address2': ['']
    });
  }

  buildSettingForm() {
    this.settingForm = this._formBuilder.group({
      'display_location': [0],
      'display_contact': [1],
      'offline_email': [1]
    });
  }

  loadDataMemberInfo() {
    this.memberForm.patchValue(this.profile);
  }

  loadDataContactInfo() {
    this.contactForm.patchValue(this.profile.contact);
  }

  loadDataSettingInfo() {
    this.settingForm.patchValue(this.profile.setting);
  }

  editMemberInfo() {
    if (this.memberForm.valid) {
      this._memberService.editMember(this.memberForm).subscribe((data) => {
        this._toastService.show('Sửa thông tin thành công!');
      });
    }
  }

  editContactInfo() {
    if (this.contactForm.valid) {
      this._memberService.editContact(this.contactForm).subscribe((data) => {
        this._toastService.show('Sửa thông tin liên lạc thành công!');
      });
    }
  }

  editSettingInfo() {
    if (this.settingForm.valid) {
      this._memberService.editSetting(this.settingForm).subscribe((data) => {
        this._toastService.show('Sửa cài đặt thành công!');
      });
    }
  }

}

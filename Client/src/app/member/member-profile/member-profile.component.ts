import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { MemberService } from '../../core/http/member.service';
import { Profile } from '../../core/models/profile';
import { TokenService } from '../../core/services/token.service';

@Component({
  selector: 'app-member-profile',
  templateUrl: './member-profile.component.html',
  styleUrls: ['./member-profile.component.css']
})
export class MemberProfileComponent implements OnInit {

  public profile: Profile = new Profile;

  constructor(
    private _router: Router,
    private _memberService: MemberService,
    private _tokenService: TokenService
  ) { }

  ngOnInit() {
    this.loadData();
  }

  loadData() {
    this._memberService.profile().subscribe((data: Profile) => {
      this.profile = data;
    });
  }

  logout() {
    this._memberService.logout().subscribe((data) => {
      this._tokenService.deleteToken();
      this._router.navigate(['/auth/login']);
    });
  }

}

import { Component, OnInit } from '@angular/core';

import { MemberService } from '../../core/http/member.service';

@Component({
  selector: 'app-member-contact',
  templateUrl: './member-contact.component.html',
  styleUrls: ['./member-contact.component.css']
})
export class MemberContactComponent implements OnInit {

  public contacts: any[];

  constructor(
    private _memberService: MemberService
  ) { }

  ngOnInit() {
    this.loadData();
  }

  loadData() {
    this._memberService.contact().subscribe((data) => {
      this.contacts = data;
    });
  }

}

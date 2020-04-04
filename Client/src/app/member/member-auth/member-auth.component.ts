import { Component, OnInit, OnDestroy, ViewEncapsulation } from '@angular/core';

@Component({
  selector: 'app-member-auth',
  templateUrl: './member-auth.component.html',
  styleUrls: ['./member-auth.component.css'],
  encapsulation: ViewEncapsulation.None
})
export class MemberAuthComponent implements OnInit, OnDestroy {

  constructor() { }

  ngOnInit() {
    // Change <body> styling
    document.body.classList.add('color-theme-blue');
  }

  ngOnDestroy() {
    // Change <body> styling
    document.body.classList.remove('color-theme-blue');
  }

}

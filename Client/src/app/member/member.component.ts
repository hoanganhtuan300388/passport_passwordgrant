import { Component, OnInit, OnDestroy, ViewEncapsulation } from '@angular/core';
import { Router, ActivatedRoute, Event, NavigationEnd } from '@angular/router';
import { filter } from 'rxjs/operators';

@Component({
  selector: 'app-member',
  templateUrl: './member.component.html',
  styleUrls: ['./member.component.css'],
  encapsulation: ViewEncapsulation.None
})
export class MemberComponent implements OnInit, OnDestroy {

  public title: string = '';
  public back: boolean = false;
  public sub: any;

  constructor(
    private _router: Router,
    private _route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.title = this._route.snapshot.firstChild.data.title;
    this.back = this._route.snapshot.firstChild.data.back;

    //subscribe router
    this._router.events.pipe(
      filter((e: Event) => e instanceof NavigationEnd),
    ).subscribe((res) => {
      let data = this._route.snapshot.firstChild.data;
      this.title = data.title;
      this.back = data.back;
    });
    
    // Change <body> styling
    document.body.classList.add('color-theme-blue', 'push-content-right', 'theme-light');
  }

  ngOnDestroy() {
    // Change <body> styling
    document.body.classList.remove('color-theme-blue', 'push-content-right', 'theme-light');
  }

}

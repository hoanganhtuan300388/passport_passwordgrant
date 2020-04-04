import { Component, OnInit } from '@angular/core';
import { Subject } from 'rxjs';

import { ToastService } from '../../../core/services/toast.service';

@Component({
  selector: 'app-toast',
  templateUrl: './toast.component.html',
  styleUrls: ['./toast.component.css']
})
export class ToastComponent implements OnInit {

  public isToast: Subject<boolean> = this._toastService.isToast;
  public message: string = '';

  constructor(
    public _toastService: ToastService
  ) { 
    this._toastService.getMessage().subscribe(message => {
      this.message = message;
    });
  }

  ngOnInit() {
  }

  hideToast() {
    this._toastService.hide();
  }

}

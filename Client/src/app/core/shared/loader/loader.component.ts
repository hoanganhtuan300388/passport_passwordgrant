import { Component, OnInit } from '@angular/core';
import { Subject } from 'rxjs';

import { LoaderService } from '../../../core/services/loader.service';

@Component({
  selector: 'app-loader',
  templateUrl: './loader.component.html',
  styleUrls: ['./loader.component.css']
})
export class LoaderComponent implements OnInit {

  public isLoading: Subject<boolean> = this._loaderService.isLoading;

  constructor(
    private _loaderService: LoaderService
  ) { }

  ngOnInit() {
  }

}

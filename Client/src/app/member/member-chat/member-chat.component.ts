import { Component, OnInit, OnDestroy, AfterViewChecked, ElementRef, ViewChild } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { interval } from 'rxjs';

import { ContactService } from '../../core/http/contact.service';

@Component({
  selector: 'app-member-chat',
  templateUrl: './member-chat.component.html',
  styleUrls: ['./member-chat.component.css']
})
export class MemberChatComponent implements OnInit, OnDestroy, AfterViewChecked {

  @ViewChild('scrollMessage', { static: true }) private scrollContainer: ElementRef;

  private _viewChecked: boolean = true;
  private _loadMessage: any;
  public sendMessageForm: FormGroup;
  public id: number;
  public profile;
  public messages = [];

  constructor(
    private _route: ActivatedRoute,
    private _formBuilder: FormBuilder,
    private _contactService: ContactService
  ) { }

  ngAfterViewChecked() {
    if (this._viewChecked === true) {
      this.scrollToBottom();
    }
  }


  ngOnInit() {
    this.buildSendMessageForm();
    this._route.params.subscribe((params) => {
      if (params['id']) {
        this.id = params['id'];
        this.loadData(this.id);
        this._loadMessage = interval(3000).subscribe((n) => {
          this._viewChecked = false;
          this.loadData(this.id)
        });
      }
    });
  }

  ngOnDestroy() {
    this._loadMessage.unsubscribe();
  }

  loadData(id: number) {
    this._contactService.getMessages(id).subscribe((data) => {
      this.profile = data.profile;
      this.messages = data.contact.messages;
    });
  }

  buildSendMessageForm() {
    this.sendMessageForm = this._formBuilder.group({
      'content': ['', [Validators.required]]
    });
  }

  sendMessage() {
    if (this.sendMessageForm.valid) {
      this._contactService.sendMessage(this.id, this.sendMessageForm).subscribe((data) => {
        this._viewChecked = true;
        this.buildSendMessageForm();
      });
    }
  }

  scrollToBottom(): void {
    try {
      this.scrollContainer.nativeElement.scrollTop = this.scrollContainer.nativeElement.scrollHeight;
    } catch (err) {

    }
  }

}

import { Member } from './member';
import { MemberContact } from './member-contact';
import { MemberSetting } from './member-setting';

export class Profile extends Member {
    contact: MemberContact = new MemberContact;
    setting: MemberSetting = new MemberSetting;
}

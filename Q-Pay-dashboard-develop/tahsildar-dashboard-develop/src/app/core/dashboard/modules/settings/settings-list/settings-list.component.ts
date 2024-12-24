import {Component} from '@angular/core';
import {SharedModule} from 'src/app/shared/modules/shared.module';
import {CmsListComponent} from 'src/app/shared/components/cms/cms-list/cms-list.component';
import {CmsService} from 'src/app/shared/components/cms/services/cms.service';
import {HttpService} from 'src/app/shared/services/http/http.service';
import {SettingsFormService} from '../cms/settings-form.service';
import {SettingsCmsService} from '../cms/settings-cms.service';
import {SettingsService} from '../services/settings.service';
import {Setting} from "../../../../../models/data/setting.model";

@Component({
  selector: 'app-settings-list',
  standalone: true,
  templateUrl: './settings-list.component.html',
  styleUrls: ['./settings-list.component.scss'],
  imports: [
    SharedModule,
    CmsListComponent,
  ],
  providers: [
    HttpService,
    SettingsService,
    SettingsFormService,
    {
      provide: CmsService<Setting>,
      useClass: SettingsCmsService,
    },
  ],
})
export class SettingsListComponent {
}

import { Injectable } from '@angular/core';
import { BaseCmsAction, BaseCmsConfig, EntityPageType } from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { SettingsFormService } from './settings-form.service';
import { AuthService } from "../../../../../shared/services/auth.service";
import { Setting } from "../../../../../models/data/setting.model";

@Injectable()
export class SettingsCmsService extends CmsService<Setting> {
  private permissionCategory="Settings"
  constructor(
    private formService: SettingsFormService,
    httpService: HttpService,
    private authService: AuthService
  ) {
    super(httpService);
  }



  cmsConfig: BaseCmsConfig<Setting> = {
    endPoint: 'setting',
    columns: [
      { key: 'id', name: 'id' },
      { key: 'key', name: 'key' },
      { key: 'value', name: 'value' }
    ],
    actions: this.authService.checkPermission(this.permissionCategory,"Edit")? [
      {
        action: BaseCmsAction.edit,
        label: "edit",
        color: 'accent',
      },
    ] : [],
    canAddNewEntity: () => false,
    entityPageType: EntityPageType.modal,
    formConfig: (item) => this.formService.getFormConfig(item)
  };
}

import { Injectable } from '@angular/core';
import { BaseCmsAction, BaseCmsConfig, EntityPageType } from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { SystemBankDataFormService } from './system-bank-data-form.service';
import {SystemBankData} from "../../../../../models/data/system-bank-data.model";
import {AuthService} from "../../../../../shared/services/auth.service";

@Injectable()
export class SystemBankDataCmsService extends CmsService<SystemBankData> {
  constructor(
    private formService: SystemBankDataFormService,
    httpService: HttpService,
    private authService: AuthService
  ) {
    super(httpService);
  }
  private hasAccess = false;

  cmsConfig: BaseCmsConfig<SystemBankData> = {
    endPoint: 'system-bank-data',
    columns: [
      { key: 'id', name: 'ID', isSortable: true },
      { key: 'bank_account_number', name: 'bank_account_number'},
      { key: 'bank.name', name: 'bank'},
      { key: 'created_at', name: 'created_at' },
    ],
    actions: this.hasAccess ? [
      {
        action: BaseCmsAction.edit,
        label: "edit",
        icon: 'edit',
        color: 'warn',
      },
    ] : [],
    canAddNewEntity: () => true,
    entityPageType: EntityPageType.modal,
    formConfig: (item) => this.formService.getFormConfig(item)
  };
}

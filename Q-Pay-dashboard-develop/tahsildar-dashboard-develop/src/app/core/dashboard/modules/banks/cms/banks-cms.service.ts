import { Injectable } from '@angular/core';
import { Bank } from 'src/app/models/data/bank.model';
import { BaseCmsAction, BaseCmsConfig, EntityPageType } from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { BanksFormService } from './banks-form.service';

@Injectable()
export class BanksCmsService extends CmsService<Bank> {
  constructor(
    private formService: BanksFormService,
    httpService: HttpService,
  ) {
    super(httpService);
  }

  cmsConfig: BaseCmsConfig<Bank> = {
    endPoint: 'bank',
    columns: [
      { key: 'id', name: 'ID', isSortable: true },
      { key: 'name', name: 'name', isSortable: true },
      { key: 'created_at', name: 'created_at' },
    ],
    actions: [
      {
        action: BaseCmsAction.delete,
        label: "delete",
        icon: 'delete',
        color: 'warn',
      },
    ],
    canAddNewEntity: () => true,
    entityPageType: EntityPageType.modal,
    formConfig: (item) => this.formService.getFormConfig(item)
  };
}

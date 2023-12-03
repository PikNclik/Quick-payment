import { Injectable } from '@angular/core';
import { Merchant } from 'src/app/models/data/merchant.model';
import { BaseCmsAction, BaseCmsConfig, EntityPageType } from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { MerchantsFormService } from './merchants-form.service';

@Injectable()
export class MerchantsCmsService extends CmsService<Merchant> {
  constructor(
    private formService: MerchantsFormService,
    httpService: HttpService,
  ) {
    super(httpService);
  }


  cmsConfig: BaseCmsConfig<Merchant> = {
    endPoint: 'user',
    columns: [
      { key: 'id', name: 'ID', isSortable: true },
      { key: 'full_name', name: 'full_name' },
      { key: 'phone', name: 'mobile_number' },
      { key: 'bank.name', name: 'bank_name' },
      { key: 'city.name', name: 'city' },
      { key: 'bank_account_number', name: 'bank_account_number' },
      { key: 'paid_amount', name: 'paid_amount' },
      { key: 'pending_amount', name: 'pending_amount' },
      { key: 'settled_amount', name: 'settled_amount' },
      { key: 'created_at', name: 'created_at' },
    ],
    actions: [
      {
        action: BaseCmsAction.edit,
        label: "edit",
        color: 'accent',
      },
      {
        action: BaseCmsAction.block,
        label: "block",
        color: 'warn',
        visible: (item: Merchant) => item.active == 1,
      },
      {
        action: BaseCmsAction.unBlock,
        label: "un_block",
        color: 'accent',
        visible: (item: Merchant) => item.active == 0,
      },
    ],
    canAddNewEntity: () => true,
    entityPageType: EntityPageType.modal,
    formConfig: (item) => this.formService.getFormConfig(item)
  };
}

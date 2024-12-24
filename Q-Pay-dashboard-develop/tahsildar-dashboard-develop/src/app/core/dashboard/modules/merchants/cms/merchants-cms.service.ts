import { Injectable } from '@angular/core';
import { Merchant } from 'src/app/models/data/merchant.model';
import { BaseCmsAction, BaseCmsConfig, EntityPageType } from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { MerchantsFormService } from './merchants-form.service';
import { AuthService } from "../../../../../shared/services/auth.service";
import { merchantsFilter } from './merchants.filter';

@Injectable()
export class MerchantsCmsService extends CmsService<Merchant> {
  private permissionCategory="Merchants"
  constructor(
    private formService: MerchantsFormService,
    httpService: HttpService,
    private authService: AuthService
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
      { key: 'business_name', name: 'business_name' },
      { key: 'profession.business_domain.business_type.name', name: 'business_type' },
      { key: 'profession.business_domain.name', name: 'business_domain' },
      { key: 'profession.name', name: 'profession' },
      // { key: 'origin.name', name: 'origin' },
      { key: 'completed', name: 'completed' },
      { key: 'created_at', name: 'created_at' },
      { key: 'activated_at', name: 'activated_at' },
    ],
    actions: (this.authService.checkPermission(this.permissionCategory,"Edit") || this.authService.checkPermission(this.permissionCategory,"Block/Unblock"))?[
    
      {
        action: BaseCmsAction.edit,
        label: "edit",
        color: 'accent',
        visible:  ()=>this.authService.checkPermission(this.permissionCategory,"Edit")
      },
      {
        action: BaseCmsAction.block,
        label: "block",
        color: 'warn',
        visible: (item: Merchant) => item.active == 1 && this.authService.checkPermission(this.permissionCategory,"Block/Unblock"),
      },
      {
        action: BaseCmsAction.unBlock,
        label: "un_block",
        color: 'accent',
        visible: (item: Merchant) => item.active == 0 && this.authService.checkPermission(this.permissionCategory,"Block/Unblock"),
      },
    ]:[] ,
    canAddNewEntity: () =>   this.authService.checkPermission(this.permissionCategory,"Add"),
    entityPageType: EntityPageType.modal,
    formConfig: (item) => this.formService.getFormConfig(item)
  };

  override filterSchema = merchantsFilter;
}

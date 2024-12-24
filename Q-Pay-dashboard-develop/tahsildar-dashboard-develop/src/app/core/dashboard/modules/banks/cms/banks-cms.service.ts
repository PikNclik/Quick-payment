import { Injectable } from '@angular/core';
import { Bank } from 'src/app/models/data/bank.model';
import { BaseCmsAction, BaseCmsConfig, EntityPageType } from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { BanksFormService } from './banks-form.service';
import { AuthService } from 'src/app/shared/services/auth.service';

@Injectable()
export class BanksCmsService extends CmsService<Bank> {
  private permissionCategory="Banks Management"
  constructor(
    private formService: BanksFormService,
    httpService: HttpService,
    private authService: AuthService
  ) {
    super(httpService);
  }

  cmsConfig: BaseCmsConfig<Bank> = {
    endPoint: 'bank',
    columns: [
      { key: 'id', name: 'ID', isSortable: true },
      { key: 'name', name: 'bank_name', isSortable: true },
      { key: 'activeString', name: 'status', isSortable: true , sortKey:"active" },
      { key: 'created_at', name: 'bank_added_at' },
    ],
    actions: this.authService.checkPermission(this.permissionCategory,"Edit")?[
      {
        action: BaseCmsAction.edit,
        label: "edit",
        icon: 'edit',
        color: 'accent'
      }
    ]:[],
    canAddNewEntity: () => this.authService.checkPermission(this.permissionCategory,"Add"),
    entityPageType: EntityPageType.modal,
    formConfig: (item) => this.formService.getFormConfig(item)
  };
}

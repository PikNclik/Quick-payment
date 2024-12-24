import { Injectable } from '@angular/core';
import { BaseCmsAction, BaseCmsConfig, EntityPageType } from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { AdminsFormService } from './admins-form.service';
import { AuthService } from "../../../../../shared/services/auth.service";
import { Admin } from 'src/app/models/data/admin.model';

@Injectable()
export class AdminsCmsService extends CmsService<Admin> {
  constructor(
    private formService: AdminsFormService,
    httpService: HttpService,
    private authService: AuthService
  ) {
    super(httpService);
  }
  
  private hasAccess = this.authService.checkRole("Super Admin");

  cmsConfig: BaseCmsConfig<Admin> = {
    endPoint: 'admin',
    columns: [
      { key: 'id', name: 'ID', isSortable: true },
      { key: 'username', name: 'username' },
      { key: 'role.name', name: 'role' },
      { key: 'created_at', name: 'created_at' },
    ],
    actions: 
    this.hasAccess?
     [
      {
        action: BaseCmsAction.edit,
        label: "edit",
        color: 'accent',
      },
      {
        action: BaseCmsAction.delete,
        label: "delete",
        color: 'warn',
      }
    ]:[],
    canAddNewEntity: () =>  this.hasAccess,
    entityPageType: EntityPageType.modal,
    formConfig: (item) => this.formService.getFormConfig(item)
  };

}

import { Injectable } from '@angular/core';
import { BaseCmsAction, BaseCmsConfig, EntityPageType } from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { RolesFormService } from './roles-form.service';
import { AuthService } from "../../../../../shared/services/auth.service";
import { Role } from 'src/app/models/data/role.model';

@Injectable()
export class RolesCmsService extends CmsService<Role> {
  constructor(
    private formService: RolesFormService,
    httpService: HttpService,
    private authService: AuthService
  ) {
    super(httpService);
  }
  private hasAccess = this.authService.checkRole("Super Admin");

  cmsConfig: BaseCmsConfig<Role> = {
    endPoint: 'role',
    columns: [
      { key: 'id', name: 'id', isSortable: true },
      { key: 'name', name: 'name' }
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
        action: BaseCmsAction.permissions,
        label: "permissions",
        color: 'red'
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

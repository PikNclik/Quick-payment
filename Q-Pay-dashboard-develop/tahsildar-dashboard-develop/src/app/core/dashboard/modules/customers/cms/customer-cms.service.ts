import {Injectable} from '@angular/core';
import {BaseCmsConfig, EntityPageType} from 'src/app/shared/components/cms/config/cms.config';
import {CmsService} from 'src/app/shared/components/cms/services/cms.service';
import {HttpService} from 'src/app/shared/services/http/http.service';
import {Customer} from "../../../../../models/data/customer.model";
import { AuthService } from 'src/app/shared/services/auth.service';

@Injectable()
export class CustomerCmsService extends CmsService<Customer> {
  private permissionCategory="Customers"
  constructor(
    httpService: HttpService,
    private authService: AuthService
  ) {
    super(httpService);
  }

  cmsConfig: BaseCmsConfig<Customer> = {
    endPoint: 'customer',
    columns: [
      {key: 'id', name: 'ID', isSortable: true},
      {key: 'name', name: 'name'},
      {key: 'phone', name: 'phone'},
      {key: 'created_at', name: 'created_at'},
    ],
    actions: [],
    canAddNewEntity: () => false,
    exportable: this.authService.checkPermission(this.permissionCategory,"Export excel"),
    exportName: "Customer",
    entityPageType: EntityPageType.modal,
  };
}

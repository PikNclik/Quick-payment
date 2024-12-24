import {Injectable} from '@angular/core';
import {BaseCmsAction, BaseCmsConfig, EntityPageType} from 'src/app/shared/components/cms/config/cms.config';
import {CmsService} from 'src/app/shared/components/cms/services/cms.service';
import {HttpService} from 'src/app/shared/services/http/http.service';
import {TerminalBank} from "../../../../../models/data/terminal-bank.model";
import {TerminalBankFormService} from "./terminal-bank-form.service";
import {AuthService} from "../../../../../shared/services/auth.service";

@Injectable()
export class TerminalBankCmsService extends CmsService<TerminalBank> {
  private permissionCategory="Terminal accounts"
  constructor(
    private formService: TerminalBankFormService,
    httpService: HttpService,
    private authService: AuthService
  ) {
    super(httpService);
  }


  cmsConfig: BaseCmsConfig<TerminalBank> = {
    endPoint: 'terminal-bank',
    columns: [
      {key: 'id', name: 'ID', isSortable: true},
      {key: 'terminal', name: 'terminal'},
      {key: 'bank.name', name: 'bank_name'},
      {key: 'bank_account_number', name: 'bank_account_number'},
      { key: 'activeString', name: 'status' },
      {key: 'created_at', name: 'created_at'},
    ],
    actions: this.authService.checkPermission(this.permissionCategory,"Edit") || this.authService.checkPermission(this.permissionCategory,"Edit Internal Commission") || this.authService.checkPermission(this.permissionCategory,"Edit External Commission") ? [
      {
        action: BaseCmsAction.edit,
        label: "edit",
        color: 'accent',
        visible:  ()=>this.authService.checkPermission(this.permissionCategory,"Edit")
      },
      {
        action: BaseCmsAction.internal_commission,
        label: "Internal Commission",
        color: 'warn',
        visible:  ()=>this.authService.checkPermission(this.permissionCategory,"Edit Internal Commission")
      },
      {
        action: BaseCmsAction.external_commission,
        label: "External Commission",
        color: 'warn',
        visible:  ()=>this.authService.checkPermission(this.permissionCategory,"Edit External Commission")
      },
    ] :[],
    canAddNewEntity: () => this.authService.checkPermission(this.permissionCategory,"Add"),
    entityPageType: EntityPageType.modal,
    formConfig: (item) => this.formService.getFormConfig(item)
  };
}

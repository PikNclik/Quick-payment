import {Injectable} from '@angular/core';
import {BaseCmsAction, BaseCmsConfig, EntityPageType} from 'src/app/shared/components/cms/config/cms.config';
import {CmsService} from 'src/app/shared/components/cms/services/cms.service';
import {HttpService} from 'src/app/shared/services/http/http.service';
import {TransactionToDo} from "../../../../../models/data/transaction-to-do.model";
import {transactionToDoFilter} from "./transaction-to-do.filter";
import { AuthService } from 'src/app/shared/services/auth.service';
import { TransactionToDoFormService } from './transaction-to-do-form.service';

@Injectable()
export class TransactionToDoCmsService extends CmsService<TransactionToDo> {
  private permissionCategory="Transaction to do"
  constructor(
    httpService: HttpService,
    private authService: AuthService,
    private formService: TransactionToDoFormService,
  ) {
    super(httpService);
  }

  cmsConfig: BaseCmsConfig<TransactionToDo> = {
    endPoint: 'transaction-to-do',
    columns: [
      {key: 'id', name: 'Qpay ID', isSortable: true},
      {key: 'payment_id', name: 'Payment ID', isSortable: true},
      {key: 'from_bank.name', name: 'from_bank'},
      {key: 'from_bank_account_number', name: 'from_bank_account_number'},
      {key: 'to_bank.name', name: 'to_bank'},
      {key: 'to_bank_account_number', name: 'to_bank_account_number'},
      {key: 'amount', name: 'transaction_value'},
      {key: 'date', name: 'transaction_date'},
      {key: 'time', name: 'transaction_time'},
      {key: 'due_date', name: 'settlement_date'},
      {key: 'executedString', name: 'status'},
    ],
    actions: this.authService.checkPermission(this.permissionCategory,"Edit")?[
      {
        action: BaseCmsAction.edit,
        label: "edit",
        color: 'accent',
      }
    ]:[],
    canAddNewEntity: () => false,
    entityPageType: EntityPageType.modal,
    formConfig: (item) => this.formService.getFormConfig(item),
    exportable:  this.authService.checkPermission(this.permissionCategory,"Export excel"),
    exportName: "Transaction To Do"
  };

  override filterSchema = transactionToDoFilter;

}

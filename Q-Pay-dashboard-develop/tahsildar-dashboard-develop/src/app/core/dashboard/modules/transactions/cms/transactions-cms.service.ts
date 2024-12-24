import { Injectable } from '@angular/core';
import { Transaction } from 'src/app/models/data/transaction.model';
import {
  BaseCmsAction,
  BaseCmsConfig,
  CellType,
} from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { transactionsFilterSchema } from './transactions.filter';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { AuthService } from 'src/app/shared/services/auth.service';

@Injectable()
export class TransactionsCmsService extends CmsService<Transaction> {

  private permissionCategory="Reports"
  constructor(
    httpService: HttpService,
    private authService: AuthService
  ) {
    super(httpService);
  }

  cmsConfig: BaseCmsConfig<Transaction> = {
    endPoint: 'payment',
    columns: [

      { key: 'id', name: 'id', isSortable: true },
      { key: 'user.full_name', name: 'username' },
      { key: 'user.phone', name: 'user_number' },
      { key: 'user.bank_account_number', name: 'user_bank_account_number' },
      { key: 'customer.phone', name: 'customer_number' },
      { key: 'amount', name: 'requested_payments' },
      { key: 'details', name: 'payment_details' },
      { key: 'status', name: 'payment_status', type: CellType.i18n },
      { key: 'type', name: 'type' },
      { key: 'user.city.name', name: 'merchant_city' },
      { key: 'hash_card', name: 'card_number' },

      { key: 'fees_percentage', name: 'fees_percentage' },
      { key: 'fees_value', name: 'fees_value' },
      { key: 'created_at', name: 'payment_request_date' },
      { key: 'scheduled_date', name: 'scheduled_date' },
      { key: 'expiry_date', name: 'expiry_date' },
      { key: 'transaction_to_do.created_at', name: 'paid_date' },
      { key: 'settlement_date', name: 'settlement_date' },
      { key: 'merchant_reference', name: 'merchant_reference' },

    ],
    actions: [
      
    ],
    exportable: this.authService.checkPermission(this.permissionCategory,"Export Excel"),
    exportName: 'Transaction',
  };

  override filterSchema = transactionsFilterSchema;
}

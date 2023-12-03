import { Injectable } from '@angular/core';
import { Transaction } from 'src/app/models/data/transaction.model';
import { BaseCmsAction, BaseCmsConfig, CellType } from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { transactionsFilterSchema } from './transactions.filter';

@Injectable()
export class TransactionsCmsService extends CmsService<Transaction> {
  cmsConfig: BaseCmsConfig<Transaction> = {
    endPoint: 'payment',
    columns: [
      { key: 'id', name: 'number', isSortable: true },
      { key: 'user.full_name', name: 'merchant' },
      { key: 'payer_mobile_number', name: 'user_number' },
      { key: 'settlement_date', name: 'settlement_date' },
      { key: 'hash_card', name: 'card_number' },
      { key: 'status', name: 'status', type: CellType.i18n },
      { key: 'amount', name: 'requested_payments' },
      { key: 'created_at', name: 'transaction_date' },
      { key: 'scheduled_date', name: 'date_form' },
      { key: 'fees_percentage', name: 'fees_percentage' },
      { key: 'fees_value', name: 'fees_value' },
      { key: 'expiry_date', name: 'date_to' },
      { key: 'user.phone', name: 'merchant_number' },
      { key: 'details', name: 'payment_details' },
      { key: 'user.bank_account_number', name: 'bank_account_number' },
    ],
    actions: [
      {
        action: BaseCmsAction.cancel,
        label: "cancel",
        icon: 'cancel',
        color: 'warn',
        visible: (item: Transaction) => item.status != 'paid' && item.status != 'refunded' && item.status != 'cancelled', // exclude (cancelled/paid)
      },
    ],
    exportable: true
  };

  override filterSchema = transactionsFilterSchema;
}

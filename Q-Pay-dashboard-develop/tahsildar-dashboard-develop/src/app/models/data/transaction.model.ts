import { Merchant } from './merchant.model';
import {TransactionToDo} from "./transaction-to-do.model";

export interface Transaction {
  id?: number;
  payer_name?: string;
  payer_mobile_number?: string;
  amount?: string;
  details?: string;
  status?: number | string;
  expiry_date?: string;
  scheduled_date?: string;
  paid_at?: string;
  user_id?: number;
  created_at?: string;
  payment_request_date?: string;
  user?: Merchant;
  merchant_reference?: string;
  transaction_to_do?: TransactionToDo;
  children?: Transaction[];
}

export let transactionStatus: Map<number, string> = new Map([
  [1, 'pending'],
  [2, 'scheduled'],
  [3, 'paid'],
  [4, 'expired'],
  [5, 'cancelled'],
  //[6, 'refunded'],
  [7, 'settled'],
]);

export let transactionType: Map<string, string> = new Map([
  ['payment', 'Payment'],
  ['transfer', 'Transfer'],
]);

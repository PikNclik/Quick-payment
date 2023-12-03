import { Merchant } from "./merchant.model";

export interface Transaction {
  id?: number;
  payer_name?: string;
  payer_mobile_number?: string;
  amount?: number;
  details?: string;
  status?: number | string;
  expiry_date?: string;
  scheduled_date?: string;
  paid_at?: string;
  user_id?: number;
  created_at?: string;
  user?: Merchant;
}

export let transactionStatus: Map<number, string> = new Map([
  [1, 'pending'],
  [2, 'scheduled'],
  [3, 'paid'],
  [4, 'expired'],
  [5, 'cancelled'],
  [6, 'refunded'],
  [7, 'settled']
]);

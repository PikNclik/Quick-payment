import {Bank} from "./bank.model";

export interface Customer {
  id?: number;
  bank_id	?: string;
  bank	?: Bank;
  bank_account_number?: string;
  phone?: string;
  created_at?: string;
}

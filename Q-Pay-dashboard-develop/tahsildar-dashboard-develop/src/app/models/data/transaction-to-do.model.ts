import {Bank} from "./bank.model";

export interface TransactionToDo {
  id?: number;
  amount?: string;
  executed?: boolean;
  executedString?: string;
  from_bank_account_number?: string;
  from_bank_id?: string;
  to_bank_account_number?: string;
  to_bank_id?: string;
  payment_id?: string;
  created_at?: string;
  date?: string;
  time?: string;
  from_bank?: Bank;
  to_bank?: Bank;
  due_date? :string;
}

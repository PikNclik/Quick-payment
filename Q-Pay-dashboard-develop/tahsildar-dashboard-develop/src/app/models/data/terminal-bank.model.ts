import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";
import { Bank } from "./bank.model";
import {SystemBankData} from "./system-bank-data.model";
import { Commission } from "./commission.model";

export interface TerminalBank {
  id?: number;
  terminal?: string;
  active?: boolean;  
  activeString ?: string;
  bank_account_number?: string;
  bank_id?: string;
  bank?: Bank;
  created_at?: string;
  internal_commission_id?:string;
  internal_commission?:Commission;
  external_commission_id?:string;
  external_commission?:Commission;

}



export function ngSelectTerminalBankConfig(config?: {
  multiple?: boolean,
  selectedBank?: any,
  initialItems?: () => any[],
}): FormNgSelectConfig<TerminalBank> {
  const multiple = config?.multiple ?? false;
  return {
    endPoint: 'terminal-bank',
    queryParams: !!(config?.selectedBank) ? "isPaginate=false&bank_id="+config?.selectedBank : "isPaginate=false",
    bindLabel: 'bank_account_number',
    bindValue: 'id',
    multiple,
    placeholder: multiple ? 'terminal banks' : 'terminal bank',
    initialItems: config?.initialItems
  };
}
import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";
import {Bank} from "./bank.model";

export interface SystemBankData {
  id?: number;
  bank_account_number?: string;
  bank?: Bank;
  created_at?: string;

  default_transaction?: boolean
}


export function ngSelectSystemBankDataConfig(config?: {
  multiple?: boolean,
  initialItems?: () => any[],
}): FormNgSelectConfig<SystemBankData> {
  const multiple = config?.multiple ?? false;
  return {
    endPoint: 'system-bank-data',
    bindLabel: 'bank_account_number',
    searchLocally: true,
    queryParams: "isPaginate=false&bank_account_number=true",
    bindValue: 'id',
    multiple,
    placeholder: multiple ? 'system_banks' : 'system_bank',
    initialItems: config?.initialItems,
    // mappingResponse: (res) => res.data,
  };
}

import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";
import { Bank } from "./bank.model";
import { City } from "./city.model";

export class Merchant {
  id?: number;
  full_name?: string;
  active?: number;
  phone?: string;
  bank_id?: number;
  bank_account_number?: string;
  remember_token?: null;
  created_at?: string;
  updated_at?: string;
  bank?: Bank;
  city?: City;
  city_id?: string;
}

export function ngSelectMerchantConfig(config?: {
  multiple?: boolean,
  initialItems?: () => any[],
}): FormNgSelectConfig<Merchant> {
  const multiple = config?.multiple ?? false;
  return {
    endPoint: 'user',
    bindLabel: 'full_name',
    bindValue: 'id',
    multiple,
    placeholder: multiple ? 'users' : 'user',
    initialItems: config?.initialItems,
    mappingResponse: (res) => res.data,
  };
}

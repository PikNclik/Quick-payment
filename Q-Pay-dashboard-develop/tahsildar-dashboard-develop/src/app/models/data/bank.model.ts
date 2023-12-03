import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";

export interface Bank {
  id?: number;
  name?: string;
  name_en?: string;
  name_ar?: string;
  created_at?: string;
}

export function ngSelectBankConfig(config?: {
  multiple?: boolean,
  initialItems?: () => any[],
}): FormNgSelectConfig<Bank> {
  const multiple = config?.multiple ?? false;
  return {
    endPoint: 'bank',
    bindLabel: 'name',
    bindValue: 'id',
    multiple,
    placeholder: multiple ? 'banks' : 'bank',
    initialItems: config?.initialItems,
    mappingResponse: (res) => res.data,
  };
}

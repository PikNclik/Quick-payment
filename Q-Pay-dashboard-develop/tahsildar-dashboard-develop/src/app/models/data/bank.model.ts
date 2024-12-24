import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";

export interface Bank {
  id?: number;
  name?: string;
  name_en?: string;
  name_ar?: string;
  created_at?: string;
  active?: boolean;
  activeString ?: string;
  translations ?: any[];
}

export function ngSelectBankConfig(config?: {
  multiple?: boolean,
  initialItems?: () => any[],
  enabled?: () => boolean
}): FormNgSelectConfig<Bank> {
  const multiple = config?.multiple ?? false;
  return {
    endPoint: 'bank_search',
    queryParams: "isPaginate=false",
    bindLabel: 'name',
    bindValue: 'id',
    multiple,
    enabled: config?.enabled,
    placeholder: multiple ? 'banks' : 'bank',
    initialItems: config?.initialItems,
  };
}

export function ngSelectFromToBankConfig(config?: {
  multiple?: boolean,
  initialItems?: () => any[],
  enabled?: () => boolean,
  placeHolder?: string
}): FormNgSelectConfig<Bank> {
  const multiple = config?.multiple ?? false;
  return {
    endPoint: 'bank_search',
    bindLabel: 'name',
    bindValue: 'id',
    multiple,
    enabled: config?.enabled,
    placeholder: config?.placeHolder ?? 'bank',
    initialItems: config?.initialItems,
    mappingResponse: (res) => res.data,
  };
}

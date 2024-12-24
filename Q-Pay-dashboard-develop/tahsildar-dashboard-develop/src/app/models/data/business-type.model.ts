import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";

export interface BusinessType {
    id?: number;
    name?: string;
}

export function ngSelectBusinessTypeConfig(config?: {
    multiple?: boolean,
    initialItems?: () => any[],
}): FormNgSelectConfig<BusinessType> {
    const multiple = config?.multiple ?? false;
    return {
        endPoint: 'business_types',
        queryParams: "isPaginate=false",
        bindLabel: 'name',
        enabled: () => true,
        bindValue: 'id',
        multiple,
        placeholder: multiple ? 'business_types' : 'business_type',
        initialItems: config?.initialItems,
    };
}
import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";
import {BusinessType} from "./business-type.model";

export interface BusinessDomain {
    id?: number;
    name?: string;
    business_type_id?: number;
  business_type?: BusinessType;
}

export function ngSelectBusinessDomainConfig(config?: {
    multiple?: boolean,
    selectedBusinessType?: any,
    initialItems?: () => any[],
}): FormNgSelectConfig<BusinessDomain> {
    const multiple = config?.multiple ?? false;
    return {

        endPoint: 'business_domains',
        queryParams: !!(config?.selectedBusinessType) ? "isPaginate=false&business_type_id="+config?.selectedBusinessType : "isPaginate=false",
        bindLabel: 'name',
        bindValue: 'id',
        multiple,
        enabled: () => true,
        placeholder: multiple ? 'business_domains' : 'business_domain',
        initialItems: config?.initialItems,
    };
}

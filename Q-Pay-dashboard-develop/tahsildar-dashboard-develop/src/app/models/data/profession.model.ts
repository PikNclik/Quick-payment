import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";
import {BusinessType} from "./business-type.model";
import {BusinessDomain} from "./buisness_domain.model";

export interface ProfessionModel {
    id?: number;
    name?: string;
    business_domain_id?: number;
    business_domain?: BusinessDomain;
}

export function ngSelectProfessionConfig(config?: {
    multiple?: boolean,
    selectedBusinessDomain?: any,
    initialItems?: () => any[],
}): FormNgSelectConfig<BusinessDomain> {
    const multiple = config?.multiple ?? false;

    return {
        endPoint: 'professions',
        queryParams: !!(config?.selectedBusinessDomain) ? "isPaginate=false&business_domain_id="+config?.selectedBusinessDomain : "isPaginate=false",
        bindLabel: 'name',
        bindValue: 'id',
        multiple,
        enabled: () => true,
        placeholder: multiple ? 'professions' : 'profession',
        initialItems: config?.initialItems,
    };
}

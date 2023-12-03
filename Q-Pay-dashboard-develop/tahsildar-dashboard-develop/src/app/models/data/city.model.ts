import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";

export interface City {
    id?: number;
    name?: string;
}

export function ngSelectCityConfig(config?: {
    multiple?: boolean,
    initialItems?: () => any[],
}): FormNgSelectConfig<City> {
    const multiple = config?.multiple ?? false;
    return {
        endPoint: 'cities',
        bindLabel: 'name',
        bindValue: 'id',
        multiple,
        placeholder: multiple ? 'cities' : 'city',
        initialItems: config?.initialItems,
        mappingResponse: (res) => res.data,
    };
}
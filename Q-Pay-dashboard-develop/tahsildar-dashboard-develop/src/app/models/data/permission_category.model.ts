import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";

export class PermissionCategory {
  id?: number;
  name?: string;
  text_to_show?: string;
}

export function ngSelectPermissionCategoryConfig(config?: {
  multiple?: boolean,
  initialItems?: () => any[],
}): FormNgSelectConfig<PermissionCategory> {
  const multiple = config?.multiple ?? false;
  return {
    endPoint: 'permission_category',
    queryParams: "isPaginate=false",
    bindLabel: 'name',
    bindValue: 'id',
    multiple,
    placeholder: multiple ? 'categories' : 'category',
    initialItems: config?.initialItems
  };
}

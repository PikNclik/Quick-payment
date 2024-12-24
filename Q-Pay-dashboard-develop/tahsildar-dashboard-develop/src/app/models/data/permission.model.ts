import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";
import { PermissionCategory } from "./permission_category.model";

export class Permission {
  id?: number;
  name?: string;
  text_to_show?: string;
  category_id?: number;
  category?: PermissionCategory;
}

export function ngSelectPermissionConfig(config?: {
  multiple?: boolean,
  initialItems?: () => any[],
}): FormNgSelectConfig<Permission> {
  const multiple = config?.multiple ?? false;
  return {
    endPoint: 'permission',
    queryParams: "isPaginate=false",
    bindLabel: 'name',
    bindValue: 'id',
    multiple,
    placeholder: multiple ? 'permissions' : 'permission',
    initialItems: config?.initialItems
  };
}

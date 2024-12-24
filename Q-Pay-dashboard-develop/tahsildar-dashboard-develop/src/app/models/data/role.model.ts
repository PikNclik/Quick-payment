import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";
import { Permission } from "./permission.model";

export class Role {
  id?: number;
  name?: string;
  permissions?: Permission[];
}

export function ngSelectRoleConfig(config?: {
  multiple?: boolean,
  initialItems?: () => any[],
}): FormNgSelectConfig<Role> {
  const multiple = config?.multiple ?? false;
  return {
    endPoint: 'role',
    queryParams: "isPaginate=false",
    bindLabel: 'name',
    bindValue: 'id',
    multiple,
    placeholder: multiple ? 'roles' : 'role',
    initialItems: config?.initialItems
  };
}

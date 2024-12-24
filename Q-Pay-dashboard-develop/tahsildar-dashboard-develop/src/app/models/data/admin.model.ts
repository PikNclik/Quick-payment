import { FormNgSelectConfig } from "src/app/shared/components/forms/config/forms.config";
import { Role } from "./role.model";

export class Admin {
  id?: number;
  role_id?: number;
  username?: string;
  password?: string;
  created_at?: string;
  updated_at?: string;
  role?: Role;
}

export function ngSelectAdminConfig(config?: {
  multiple?: boolean,
  initialItems?: () => any[],
}): FormNgSelectConfig<Admin> {
  const multiple = config?.multiple ?? false;
  return {
    endPoint: 'admin',
    queryParams: "isPaginate=false&hide_admin=false",
    bindLabel: 'username',
    bindValue: 'id',
    multiple,
    placeholder: multiple ? 'admins' : 'admin',
    initialItems: config?.initialItems,
  };
}

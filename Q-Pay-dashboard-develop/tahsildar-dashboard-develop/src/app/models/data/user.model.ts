import { Permission } from "./permission.model";

export interface User {
  id?: number;
  username?: string;
  accessToken?: string;
  abilities ?: string[];
  role_id?:number,
  permissions?: Permission[]
}

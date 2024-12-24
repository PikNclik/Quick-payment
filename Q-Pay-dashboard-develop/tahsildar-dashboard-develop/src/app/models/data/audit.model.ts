
export interface Audit {
  id?: number;
  user_name?: string;
  event?: string;
  aud_type?: string;
  auditable_id?: string;
  old_values?: string;
  new_values?: string;
  created_at?: string;
  updated_at?: string;
}


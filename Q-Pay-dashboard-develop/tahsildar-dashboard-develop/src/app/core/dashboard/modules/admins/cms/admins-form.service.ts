import { Injectable } from '@angular/core';
import { Validators } from '@angular/forms';
import { Admin } from 'src/app/models/data/admin.model';
import { ngSelectRoleConfig } from 'src/app/models/data/role.model';
import { FormConfig, FormInputType } from 'src/app/shared/components/forms/config/forms.config';
import { AuthService } from 'src/app/shared/services/auth.service';

@Injectable()
export class AdminsFormService {

 
  constructor(
    private authService: AuthService,
  ) {
  }

  public getFormConfig(item?: Admin): FormConfig<Admin> {

    
    return {
      endPoint: 'admin',
      title: item ? "edit_admin" : "new_admin",
      formFields: [
        {
          formControlName: 'username',
          inputType: FormInputType.text,
          label: 'username',
          validators: [Validators.required,Validators.minLength(3),Validators.maxLength(100)],
          defaultValue: item?.username,
        },
        {
          formControlName: 'password',
          inputType: FormInputType.password,
          label: 'password',
          validators: [Validators.minLength(8),Validators.maxLength(20),Validators.pattern(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/)],
          defaultValue: item?.password,
        },
        {
          formControlName: 'role_id',
          inputType: FormInputType.ngSelect,
          label: 'role',
          validators: [Validators.required],
          defaultValue: item?.role_id,
          ngSelectConfig: () => ngSelectRoleConfig({
            initialItems: () => [item?.role]
          }),
        }
      ]
    };
  }
}

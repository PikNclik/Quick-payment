import { Injectable } from '@angular/core';
import { Validators } from '@angular/forms';
import { ngSelectRoleConfig, Role } from 'src/app/models/data/role.model';
import { FormConfig, FormInputType } from 'src/app/shared/components/forms/config/forms.config';
import { AuthService } from 'src/app/shared/services/auth.service';

@Injectable()
export class RolesFormService {

 
  constructor(
    private authService: AuthService,
  ) {
  }

  public getFormConfig(item?: Role): FormConfig<Role> {

    
    return {
      endPoint: 'role',
      title: item ? "edit_role" : "new_role",
      formFields: [
        {
          formControlName: 'name',
          inputType: FormInputType.text,
          label: 'name',
          validators: [Validators.required,Validators.minLength(3),Validators.maxLength(100)],
          defaultValue: item?.name,
        }
      ]
    };
  }
}

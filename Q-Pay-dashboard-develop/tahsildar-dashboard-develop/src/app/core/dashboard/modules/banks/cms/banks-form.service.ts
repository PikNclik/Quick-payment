import { Injectable } from '@angular/core';
import { Validators } from '@angular/forms';
import { Bank } from 'src/app/models/data/bank.model';
import { FormConfig, FormInputType } from 'src/app/shared/components/forms/config/forms.config';
import {AuthService} from "../../../../../shared/services/auth.service";

@Injectable()
export class BanksFormService {

  constructor(private authService: AuthService) {
  }
  public getFormConfig(item?: Bank): FormConfig<Bank> {
    return {
      endPoint: 'bank',
      title: item ? "edit_bank" : "new_bank",
      formFields: [
        {
          formControlName: 'name_en',
          inputType: FormInputType.text,
          label: 'name_en',
          validators: [Validators.required],
          defaultValue: item?.translations?.find(t => t.locale === "en")?.name ,
        },
        {
          formControlName: 'name_ar',
          inputType: FormInputType.text,
          label: 'name_ar',
          validators: [Validators.required],
          defaultValue: item?.translations?.find(t => t.locale === "ar")?.name ,
        },
        {
          formControlName: 'active',
          inputType: FormInputType.checkbox,
          label: 'active',
          validators: [Validators.required],
          defaultValue: item?.active || 0,
          enabled: () => true
        },
      ],
    };
  }
}

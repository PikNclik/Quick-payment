import {Injectable} from '@angular/core';
import {Validators} from '@angular/forms';
import {FormConfig, FormInputType} from 'src/app/shared/components/forms/config/forms.config';
import {Setting} from "../../../../../models/data/setting.model";

@Injectable()
export class SettingsFormService {

  public getFormConfig(item?: Setting): FormConfig<Setting> {
    return {
      endPoint: 'setting',
      title: item ? "edit_setting" : "new_setting",
      formFields: [
        {
          formControlName: 'key',
          inputType: FormInputType.text,
          label: 'key',
          validators: [],
          defaultValue: item?.key,
          enabled: () => false
        },
        {
          formControlName: 'value',
          inputType: FormInputType.text,
          label: 'value',
          validators: [Validators.required],
          defaultValue: item?.value,
        }
      ],
    };
  }
}

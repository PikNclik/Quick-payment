import { Injectable } from '@angular/core';
import { Validators } from '@angular/forms';
import { FormConfig, FormInputType } from 'src/app/shared/components/forms/config/forms.config';
import {SystemBankData} from "../../../../../models/data/system-bank-data.model";
import {ngSelectBankConfig} from "../../../../../models/data/bank.model";

@Injectable()
export class SystemBankDataFormService {

  public getFormConfig(item?: SystemBankData): FormConfig<SystemBankData> {
    return {
      endPoint: 'system-bank-data',
      title: item ? "edit_system_bank_data" : "new_system_bank_data",
      formFields: [
        {
          formControlName: 'bank_account_number',
          inputType: FormInputType.number,
          label: 'bank_account_number',
          validators: [Validators.required,Validators.min(0),Validators.minLength(7),Validators.maxLength(7)],
          defaultValue: item?.bank_account_number,
        },{
          formControlName: 'bank_account_number_confirmation',
          inputType: FormInputType.number,
          label: 'bank_account_number_confirmation',
          validators: [Validators.required,Validators.min(0),Validators.minLength(7),Validators.maxLength(7)],
          defaultValue: item?.bank_account_number,
        },
        {
          formControlName: 'bank_id',
          inputType: FormInputType.ngSelect,
          label: 'bank',
          validators: item ? [] : [Validators.required],
          defaultValue: item?.bank?.id,
          ngSelectConfig: () => ngSelectBankConfig({
            enabled: () => !item
          }),
        },
        {
          formControlName: 'default_transaction',
          inputType: FormInputType.checkbox,
          label: 'default_transaction',
          validators: [],
          defaultValue: item?.default_transaction || false,
        }
      ],
    };
  }
}

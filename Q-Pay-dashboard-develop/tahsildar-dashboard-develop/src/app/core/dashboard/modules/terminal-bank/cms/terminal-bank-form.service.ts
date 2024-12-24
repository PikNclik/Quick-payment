import { Injectable } from '@angular/core';
import { Validators } from '@angular/forms';
import { FormConfig, FormInputType } from 'src/app/shared/components/forms/config/forms.config';
import {TerminalBank} from "../../../../../models/data/terminal-bank.model";
import {ngSelectSystemBankDataConfig} from "../../../../../models/data/system-bank-data.model";
import { ngSelectBankConfig } from 'src/app/models/data/bank.model';

@Injectable()
export class TerminalBankFormService {

  public getFormConfig(item?: TerminalBank): FormConfig<TerminalBank> {
    return {
      endPoint: 'terminal-bank',
      title: item ? "edit_terminal_bank" : "new_terminal_bank",
      formFields: [
        {
          formControlName: 'terminal',
          inputType: FormInputType.text,
          label: 'terminal',
          validators: [],
          defaultValue: item?.terminal,
        },
        {
          formControlName: 'bank_id',
          inputType: FormInputType.ngSelect,
          label: 'bank',
          validators: [Validators.required],
          defaultValue: item?.bank_id,
          ngSelectConfig: ngSelectBankConfig
        },
        {
          formControlName: 'bank_account_number',
          inputType: FormInputType.text,
          label: 'bank_account_number',
          validators: [Validators.required],
          defaultValue: item?.bank_account_number,
        },
        {
          formControlName: 'active',
          inputType: FormInputType.checkbox,
          label: 'active',
          validators: [Validators.required],
          defaultValue: item?.active || 0,
          enabled: () => true
        }
      ],
    };
  }
}

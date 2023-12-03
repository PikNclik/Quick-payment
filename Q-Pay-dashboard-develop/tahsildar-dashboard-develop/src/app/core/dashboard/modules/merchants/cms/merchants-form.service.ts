import { Injectable } from '@angular/core';
import { Validators } from '@angular/forms';
import { ngSelectBankConfig } from 'src/app/models/data/bank.model';
import { ngSelectCityConfig } from 'src/app/models/data/city.model';
import { Merchant } from 'src/app/models/data/merchant.model';
import { FormConfig, FormInputType } from 'src/app/shared/components/forms/config/forms.config';

@Injectable()
export class MerchantsFormService {

  public getFormConfig(item?: Merchant): FormConfig<Merchant> {
    return {
      endPoint: 'user',
      title: item ? "edit_user" : "new_user",
      formFields: [
        {
          formControlName: 'full_name',
          inputType: FormInputType.text,
          label: 'full_name',
          validators: [Validators.required],
          defaultValue: item?.full_name,
        },
        {
          formControlName: 'phone',
          inputType: FormInputType.text,
          label: 'mobile_number',
          validators: [Validators.required],
          defaultValue: item?.phone,
        },
        {
          formControlName: 'bank_id',
          inputType: FormInputType.ngSelect,
          label: 'bank',
          validators: [],
          defaultValue: item?.bank?.id,
          ngSelectConfig: () => ngSelectBankConfig({
            initialItems: () => [item?.bank]
          }),
        },
        {
          formControlName: 'city_id',
          inputType: FormInputType.ngSelect,
          label: 'city',
          validators: [],
          defaultValue: item?.city?.id,
          ngSelectConfig: () => ngSelectCityConfig({
            initialItems: () => [item?.city]
          }),
        },
        {
          formControlName: 'bank_account_number',
          inputType: FormInputType.text,
          label: 'bank_account_number',
          validators: [Validators.required],
          defaultValue: item?.bank_account_number,
        },
      ],
    };
  }
}

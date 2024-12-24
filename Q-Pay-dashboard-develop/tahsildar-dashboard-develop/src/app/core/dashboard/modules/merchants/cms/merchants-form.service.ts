import { EventEmitter, Injectable } from '@angular/core';
import { FormGroup, Validators } from '@angular/forms';
import { ngSelectBankConfig } from 'src/app/models/data/bank.model';
import { ngSelectBusinessTypeConfig } from 'src/app/models/data/business-type.model';
import { ngSelectCityConfig } from 'src/app/models/data/city.model';
import { Merchant } from 'src/app/models/data/merchant.model';
import { FormConfig, FormInputType } from 'src/app/shared/components/forms/config/forms.config';
import { AuthService } from 'src/app/shared/services/auth.service';
import { ngSelectProfessionConfig } from "../../../../../models/data/profession.model";
import { ngSelectBusinessDomainConfig } from "../../../../../models/data/buisness_domain.model";

@Injectable()
export class MerchantsFormService {
  businessDomainEvent = new EventEmitter<any>();
  selectedBusinessType: any = null;

  professionEvent = new EventEmitter<any>();
  selectedBusinessDomain: any = null;

  private urlPattern = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/;
  private hasAccess = this.authService.checkPermission("Merchants", "Show all edit fields");
  private permissionCategory = "Merchants"
  constructor(
    private authService: AuthService,
  ) {
  }

  public getFormConfig(item?: Merchant): FormConfig<Merchant> {
    this.selectedBusinessType = item?.profession?.business_domain?.business_type?.id || null;
    this.selectedBusinessDomain = item?.profession?.business_domain?.id || null;
    const adminCols = [
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
        inputType: FormInputType.number,
        label: 'bank_account_number',
        validators: [Validators.required, Validators.min(0), Validators.minLength(7), Validators.maxLength(7)],
        defaultValue: item?.bank_account_number,
        enabled: () => false
      },
      {
        formControlName: 'webhook_url',
        inputType: FormInputType.text,
        label: 'webhook_url',
        validators: [Validators.pattern(this.urlPattern)],
        defaultValue: item?.webhook_url,
      }
    ];

    const customerSupportCols = [
      {
        formControlName: 'business_type_id',
        inputType: FormInputType.ngSelect,
        label: 'business_type',
        validators: [],
        onChange: (form: FormGroup) => {
          this.selectedBusinessType = form.controls["business_type_id"].value;
          form.controls["business_domain_id"].setValue("");
          form.controls["profession_id"].setValue("")
          this.businessDomainEvent.emit(this.selectedBusinessType?"isPaginate=false&business_type_id="+this.selectedBusinessType :null);
        },

        defaultValue: item?.profession?.business_domain?.business_type?.id,
        ngSelectConfig: () => {
          return {
            ...ngSelectBusinessTypeConfig({
              initialItems: () => [item?.profession?.business_domain?.business_type]
            })
          }
        },
      },
      {
        formControlName: 'business_domain_id',
        inputType: FormInputType.ngSelect,
        label: 'business_domain_id',
        validators: [],
        onChange: (form: FormGroup) => {
          this.selectedBusinessDomain = form.controls["business_domain_id"].value;
          form.controls["profession_id"].setValue("")
          this.professionEvent.emit(this.selectedBusinessDomain ? "isPaginate=false&business_domain_id="+this.selectedBusinessDomain:  null);
        },
        defaultValue: item?.profession?.business_domain?.id,
        ngSelectConfig: () => {
          return {
            refresh: this.businessDomainEvent,
            ...ngSelectBusinessDomainConfig({
              selectedBusinessType: this.selectedBusinessType,
              initialItems: () => [item?.profession?.business_domain]
            })
          }
        },
      },
      {
        formControlName: 'profession_id',
        inputType: FormInputType.ngSelect,
        label: 'profession',
        validators: [],
        enabled: () => true,
        defaultValue: item?.profession?.id,
        ngSelectConfig: () => {
          return {
            refresh: this.professionEvent,
            ...ngSelectProfessionConfig({
              selectedBusinessDomain: this.selectedBusinessDomain,
              initialItems: () => [item?.profession],
            })

          }
        },
      },
      {
        formControlName: 'business_name',
        inputType: FormInputType.text,
        label: 'business_name',
        validators: [],
        defaultValue: item?.business_name,
        enabled: () => true
      },
    ];
    return {
      endPoint: 'user',
      title: item ? "edit_user" : "new_user",
      formFields: this.hasAccess ? [...adminCols, ...customerSupportCols] : customerSupportCols,
    };
  }
}

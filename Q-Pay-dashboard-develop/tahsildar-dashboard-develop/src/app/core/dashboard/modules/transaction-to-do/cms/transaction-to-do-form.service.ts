import {EventEmitter, Injectable} from '@angular/core';
import {FormGroup, Validators} from '@angular/forms';
import { FormConfig, FormInputType } from 'src/app/shared/components/forms/config/forms.config';
import { AuthService } from 'src/app/shared/services/auth.service';
import { TransactionToDo } from 'src/app/models/data/transaction-to-do.model';
import * as moment from 'moment';

@Injectable()
export class TransactionToDoFormService {
  businessDomainEvent = new EventEmitter<any>();
  selectedBusinessType:string  | null = null;

  professionEvent = new EventEmitter<any>();
  selectedBusinessDomain:string  | null = null;

  private  urlPattern =  /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/;

  constructor(
    private authService: AuthService,
  ) {
  }

  public getFormConfig(item?: TransactionToDo): FormConfig<TransactionToDo> {

    const cols=[
      {
        formControlName: 'due_date',
        inputType: FormInputType.date,
        label: 'settlement_date',
        validators: [Validators.required],
        defaultValue: item?.due_date,
        onDateSelect:(form:FormGroup,value: any) => {
          const date= moment(value).format("YYYY-MM-DD");
           form.controls["due_date"].setValue(date);
        }
      }
    ];

    
    return {
      endPoint: 'transaction-to-do',
      title: item ? "edit_transaction" : "new_transaction",
      formFields: cols,
    };
  }
}

import { Component, EventEmitter, Input, Output } from '@angular/core';
import { FormGroup, Validators, FormControl } from '@angular/forms';
import { FileDragDropComponent } from '../file-drag-drop/file-drag-drop.component';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatButtonModule } from '@angular/material/button';
import { MatInputModule } from '@angular/material/input';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { FormConfig, FormFieldData, FormInputType, FormSelectConfig } from '../config/forms.config';
import { MatSelectModule } from '@angular/material/select';
import { DndDirective } from '../file-drag-drop/directives/dnd.directive';
import { MatOptionModule } from '@angular/material/core';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatSlideToggleModule } from '@angular/material/slide-toggle';
import { Observable, finalize } from 'rxjs';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { MAT_DATE_FORMATS } from '@angular/material/core';
import { MatMomentDateModule } from '@angular/material-moment-adapter';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { GenericNgSelectComponent } from '../generic-ng-select/generic-ng-select.component';

export const MY_DATE_FORMAT = {
  parse: {
    dateInput: "YYYY-MM-DD",
  },
  display: {
    dateInput: "YYYY-MM-DD",
    monthYearLabel: 'MMM YYYY',
    dateA11yLabel: 'LL',
    monthYearA11yLabel: 'MMMM YYYY',
  },
};

@Component({
  selector: 'app-generic-form-builder',
  templateUrl: './generic-form-builder.component.html',
  styleUrls: ['./generic-form-builder.component.scss'],
  standalone: true,
  imports: [
    SharedModule,
    MatIconModule,
    MatInputModule,
    MatButtonModule,
    MatSelectModule,
    MatOptionModule,
    MatCheckboxModule,
    MatFormFieldModule,
    MatDatepickerModule,
    MatMomentDateModule,
    MatSlideToggleModule,
    MatProgressBarModule,
    FileDragDropComponent,
    GenericNgSelectComponent,
    MatProgressSpinnerModule,
  ],
  providers: [
    DndDirective,
    ErrorService,
    { provide: MAT_DATE_FORMATS, useValue: MY_DATE_FORMAT },
    MatDatepickerModule,
  ]
})
export class GenericFormBuilderComponent<T> {
  public formInputType = FormInputType;

  /**
   * @param {FormConfig<T>} config generic form config
   */
  public config!: FormConfig<T>;
  @Input() set formConfig(value: FormConfig<T>) {
    this.config = value;
    this.initializeForm();
  }

  /**
   * @param {T | undefined} item to fill form with item data
   */
  @Input() item?: T;

  /**
   * @param {boolean} loading to disable button
   */
  @Input() loading: boolean = false;

  /**
   * @param {EventEmitter<T>} onSumbit emit to parent form values
   */
  @Output() onSumbit: EventEmitter<T> = new EventEmitter();

  /**
   * @param {FormGroup} formGroup tracks the value and validity state of a group of `item` FormControl instances.
   */
  public formGroup!: FormGroup;

  constructor(private errorService: ErrorService) { }

  /**
   * initialize item form`
   */
  private initializeForm(): void {
    const group: any = {};
    this.config.formFields.forEach(element => {
      group[element.formControlName] = new FormControl(element.defaultValue, element.validators);
      this.initializeFormField(group[element.formControlName], element);
    });
    this.formGroup = new FormGroup(group);
    this.config.formGroup = this.formGroup;
  }

  /**
   * sumbit form values
   */
  public submit(): void {
    const item: T = this.formGroup.value;
    this.config.staticData?.forEach((e) => { item[e.key] = e.value });
    this.onSumbit.emit(item);
  }

  /**
   * detect when file dragged or browsed
   * @param event file object
   */
  public onFileSelected(formFieldData: FormFieldData, event: any) {
    const control = this.formGroup.controls[formFieldData.formControlName];
    if (event == null) {
      control.addValidators(Validators.required);
    }
    control.setValue(event);
  }

  /**
   * config form-field
   * @param {FormControl} formControl
   * @param {FormFieldData} formFieldData
   */
  private initializeFormField(formControl: FormControl, formFieldData: FormFieldData): void {
    if (formFieldData.enabled?.() == false) formControl.disable();
    this.initializeSelectOptions(formFieldData.selectConfig);
  }

  /**
   * get mat-select input options
   * @param {FormSelectConfig} config mat-select config
   */
  public initializeSelectOptions(config?: FormSelectConfig): void {
    if (!config?.loadOptions) return;
    config.options = [];

    const loadOptions = config.loadOptions!();
    if (loadOptions instanceof Observable) {
      config.loading = true;
      loadOptions
        .pipe(finalize(() => config.loading = false))
        .subscribe({
          next: (data: any) => {
            if (data.results) config.options = data.results || [];
            else if (Array.isArray(data)) config.options = data;
          },
          error: (error) => {
            this.errorService.showMessage(error?.message || error);
          }
        });
    } else if (Array.isArray(loadOptions)) {
      config.options = loadOptions;
    }
  }

  /**
   * listen for input changes
   * @param {FormFieldData} event
   * @param {any} event
   */
  public onChange(formField: FormFieldData, event: any) {
    if (formField.onChange) formField.onChange!(this.formGroup, event);
  }

  /**
   * update formGroup control with new ng-select value
   *
   * @param {FormFieldData} formField
   * @param {any} event ng-select event
   */
  public onNgSelectChange(formField: FormFieldData, event: any): void {
    this.formGroup.controls[formField.formControlName]?.setValue(event);
  }
}

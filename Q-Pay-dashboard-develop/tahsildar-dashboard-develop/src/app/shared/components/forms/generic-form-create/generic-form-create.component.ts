import { Component, Input, ViewChild } from '@angular/core';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { FormDataService } from '../service/form.service';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { Location } from '@angular/common';
import { FormConfig } from '../config/forms.config';
import { GenericFormBuilderComponent } from '../generic-form-builder/generic-form-builder.component';

@Component({
  selector: 'app-generic-form-create',
  templateUrl: './generic-form-create.component.html',
  styleUrls: ['./generic-form-create.component.scss'],
  standalone: true,
  imports: [
    SharedModule,
    MatProgressBarModule,
    GenericFormBuilderComponent,
  ],
  providers: [
    FormDataService,
  ]
})
export class GenericFormCreateComponent<T> {
  @ViewChild("formBuilder", { static: false }) formBuilder?: GenericFormBuilderComponent<T>;

  /**
   * @param {FormConfig<T>} formConfig generic form config
   */
  @Input() formConfig!: FormConfig<T>;

  /**
   * @param {boolean} loading to disable button
   */
  @Input() loading: boolean = false;

  /**
   * @param {(success: boolean) => void} callback callback when request success
   */
  @Input() callback?: (success: boolean) => void;

  constructor(
    private formDataService: FormDataService,
    private errorService: ErrorService,
    private location: Location,
  ) { }

  /**
   * send item data to server to create new one
   * @param {T} event item data
   */
  public onSubmit(event: T) {
    this.loading = true;
    const data = this.formConfig.parseToFormData ? this.formDataService.parseToFormData(event) : event;
    this.formDataService.post(this.formConfig.endPoint, data)
      .subscribe({
        next: () => {
          if (this.callback) this.callback?.(true)
          else this.location.back();
        },
        error: (error) => {
          this.loading = false;
          this.errorService.showMessage(error?.message || error);
          this.callback?.(false);
        }
      })
  }
}

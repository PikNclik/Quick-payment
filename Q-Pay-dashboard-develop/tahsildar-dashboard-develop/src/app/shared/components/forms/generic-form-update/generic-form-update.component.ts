import { ChangeDetectorRef, Component, EventEmitter, Input, OnInit, Output, ViewChild } from '@angular/core';
import { FormConfig } from '../config/forms.config';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { GenericFormBuilderComponent } from '../generic-form-builder/generic-form-builder.component';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { Location } from '@angular/common';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { ActivatedRoute } from '@angular/router';
import { FormDataService } from '../service/form.service';
import { finalize } from 'rxjs';

@Component({
  selector: 'app-generic-form-update',
  templateUrl: './generic-form-update.component.html',
  styleUrls: ['./generic-form-update.component.scss'],
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
export class GenericFormUpdateComponent<T> implements OnInit {

  @ViewChild("formBuilder", { static: false }) formBuilder?: GenericFormBuilderComponent<T>;

  /**
   * @param {FormConfig<T>} formConfig generic form config
   */
  @Input() formConfig!: FormConfig<T>;

  /**
   * @param {T} item inject item data instead of fetch it in this component
   */
  @Input() item?: T;

  /**
   * @param {EventEmitter<T>} onDataFetched event emitter to notify parent that new data is fetched from server
   * it used to modify the list like pipe date or edit some element in the list
   */
  @Output() onDataFetched: EventEmitter<T> = new EventEmitter();

  /**
   * @param {(success: boolean) => void} callback callback when request success
   */
  @Input() callback?: (success: boolean) => void;

  /**
   * @param {boolean} loading to disable button
   */
  @Input() loading: boolean = false;

  public id?: string;

  constructor(
    private formDataService: FormDataService,
    private errorService: ErrorService,
    private cdr: ChangeDetectorRef,
    readonly route: ActivatedRoute,
    private location: Location,
  ) {
    route.params.subscribe(data => { this.id = data["id"] });
  }

  async ngOnInit() {
    if (this.id && !this.item) {
      this.item = await this.getItemById(`${this.formConfig.endPoint}/${this.id}`);
      this.onDataFetched.emit(this.item);
    }
  }

  ngAfterViewInit(): void {
    this.cdr.detectChanges();
  }

  /**
   * get item details from server
   * @param {string} endPoint api which called to fetch data form server
   * @returns {Promise<T | null>} fetched item
   */
  public getItemById(endPoint?: string): Promise<T | undefined> {
    this.loading = true;
    return new Promise((resolve, reject) => {
      this.formDataService.get<T>(endPoint)
        .pipe(finalize(() => this.loading = false))
        .subscribe({
          next: (data) => {
            resolve(data);
          },
          error: (error) => {
            this.errorService.showMessage(error?.message || error);
            resolve(undefined);
          }
        });
    });
  }

  /**
   * send item data to server to create new one
   * @param {T} event item data
   */
  public onSubmit(event: T) {
    const data = this.formConfig.parseToFormData ? this.formDataService.parseToFormData(event) : event;
    this.loading = true;
    this.formDataService.put(`${this.formConfig.endPoint}/${this.id}`, data)
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

import { ChangeDetectorRef, Component, Input, ViewChild } from '@angular/core';
import { FormConfig } from 'src/app/shared/components/forms/config/forms.config';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { GenericFormUpdateComponent } from 'src/app/shared/components/forms/generic-form-update/generic-form-update.component';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';

@Component({
  selector: 'app-cms-update',
  standalone: true,
  templateUrl: './cms-update.component.html',
  styleUrls: ['./cms-update.component.scss'],
  imports: [
    SharedModule,
    MatIconModule,
    MatButtonModule,
    MatProgressSpinnerModule,
    GenericFormUpdateComponent,
  ]
})
export class CmsUpdateComponent<T> {
  @ViewChild("form", { static: true }) form!: GenericFormUpdateComponent<T>;
  @Input() formConfig!: FormConfig<T>;
  @Input() loading: boolean = false;
  @Input() fetchingData: boolean = false;

  constructor(public cdr: ChangeDetectorRef) { }

  ngAfterViewInit(): void {
    this.cdr.detectChanges();
  }

  /**
   * called from cms-create.service.ts to call http api
   */
  public onSubmit() { }
}

import { AfterViewInit, ChangeDetectorRef, Component, Input, ViewChild } from '@angular/core';
import { FormConfig } from 'src/app/shared/components/forms/config/forms.config';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { GenericFormCreateComponent } from 'src/app/shared/components/forms/generic-form-create/generic-form-create.component';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';

@Component({
  selector: 'app-cms-create',
  standalone: true,
  templateUrl: './cms-create.component.html',
  styleUrls: ['./cms-create.component.scss'],
  imports: [
    SharedModule,
    MatIconModule,
    MatButtonModule,
    MatProgressSpinnerModule,
    GenericFormCreateComponent,
  ],
})
export class CmsCreateComponent<T> implements AfterViewInit {
  @ViewChild("form", { static: true }) form!: GenericFormCreateComponent<T>;
  @Input() formConfig!: FormConfig<T>;
  @Input() loading: boolean = false;

  constructor(private cdr: ChangeDetectorRef) { }

  ngAfterViewInit(): void {
    this.cdr.detectChanges();
  }

  /**
   * called from cms-create.service.ts to call http api
   */
  public onSubmit() { }
}

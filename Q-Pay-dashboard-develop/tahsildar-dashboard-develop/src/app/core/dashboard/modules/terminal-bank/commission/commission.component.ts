import { Component, Inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MAT_DIALOG_DATA, MatDialogModule, MatDialogRef } from '@angular/material/dialog';
import { MatButtonModule } from '@angular/material/button';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { CommissionService } from '../services/commission.service';
import { Commission } from 'src/app/models/data/commission.model';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { finalize } from 'rxjs';
import { MatSelectModule } from '@angular/material/select';

@Component({
  selector: 'app-commission',
  standalone: true,
  imports: [
    CommonModule,
    MatFormFieldModule,
    MatButtonModule,
    MatSelectModule,
    MatInputModule,
    MatCardModule,
    MatProgressSpinnerModule,
    MatDialogModule,
    SharedModule,
    MatIconModule
  ],
  providers: [
    CommissionService
  ],
  templateUrl: './commission.component.html',
  styleUrls: ['./commission.component.scss']
})
export class CommissionComponent {
  loading = false;
  public formGroup!: FormGroup;
  title = "";
  constructor(
    private formBuilder: FormBuilder,
    @Inject(MAT_DIALOG_DATA)
    public data: { terminalBankId: number, type: string },
    protected dialogRef: MatDialogRef<CommissionComponent>,
    private errorService: ErrorService,
    private commissionService: CommissionService
  ) {

  }
  ngOnInit(): void {
    this.title = this.data.type + " Commission";
    this.initializeForm();
    this.getCommission();
  }

  private initializeForm(): void {
    this.formGroup = this.formBuilder.group({
      commission_percentage: [0, [Validators.required, Validators.min(0), Validators.max(100)]],
      commission_fixed: [0, [Validators.required, Validators.min(0)]],
      min: [0, [Validators.required, Validators.min(0)]],
      max: [0, [Validators.required, Validators.min(0)]],
      bank_account_number: ['', [Validators.required]],
      type: ['ignore', [Validators.required]],


    });
  }
  getCommission() {
    this.loading = true;
    let url = (this.data.type == "Internal" ? "internal/" : "external/") + this.data.terminalBankId;
    this.commissionService.get<Commission>(url)
      .subscribe({
        next: (data: Commission) => {
          if(data!=null){
            this.formGroup.setValue({
              commission_percentage: data.commission_percentage, 
              commission_fixed: data.commission_fixed, 
              min: data.min, 
              max: data.max, 
              bank_account_number: data.bank_account_number,
              type: data.type
            });
          }

          this.loading = false;
        },
        error: (error) => {
          this.errorService.showMessage(error?.message || error)
          this.loading = false;
        },
      });
  }
  public submit() {
    this.loading = true;
    let url = (this.data.type == "Internal" ? "internal/" : "external/") + this.data.terminalBankId;
    this.commissionService.post(url,this.formGroup.value)
      .pipe(finalize(() => this.loading = false))
      .subscribe({
        next: () => {
          this.dialogRef.close();
        },
        error: (error) => {
          this.errorService.showMessage(error?.message || error);
        },
      });
  }

}

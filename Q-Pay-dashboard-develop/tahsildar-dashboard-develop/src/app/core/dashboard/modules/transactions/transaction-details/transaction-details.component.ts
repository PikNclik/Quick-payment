import { ChangeDetectorRef, Component, Inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatButtonModule } from '@angular/material/button';
import { MAT_DIALOG_DATA, MatDialogModule, MatDialogRef } from '@angular/material/dialog';
import { Transaction } from 'src/app/models/data/transaction.model';
import { SharedModule } from 'src/app/shared/modules/shared.module';

@Component({
  selector: 'app-transaction-details',
  standalone: true,
  imports: [
    CommonModule,
    MatDialogModule,
    MatButtonModule,
    SharedModule
  ],
  templateUrl: './transaction-details.component.html',
  styleUrls: ['./transaction-details.component.scss']
})
export class TransactionDetailsComponent {

  constructor(
    @Inject(MAT_DIALOG_DATA)
    public data: { transaction: any },
    private cdr: ChangeDetectorRef,
    protected dialogRef: MatDialogRef<TransactionDetailsComponent>

  ) { }


}

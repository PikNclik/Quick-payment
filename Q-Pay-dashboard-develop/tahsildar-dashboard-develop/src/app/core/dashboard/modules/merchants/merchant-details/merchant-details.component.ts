import { ChangeDetectorRef, Component, Inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MAT_DIALOG_DATA, MatDialogModule, MatDialogRef } from '@angular/material/dialog';
import { MatButtonModule } from '@angular/material/button';
import { User } from 'src/app/models/data/user.model';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { Merchant } from 'src/app/models/data/merchant.model';

@Component({
  selector: 'app-merchant-details',
  standalone: true,
  imports: [
    CommonModule,
    MatDialogModule,
    MatButtonModule,
    SharedModule
  ],
  templateUrl: './merchant-details.component.html',
  styleUrls: ['./merchant-details.component.scss']
})
export class MerchantDetailsComponent {

  
  constructor(
    @Inject(MAT_DIALOG_DATA)
    public data: { merchant: Merchant },
    private cdr: ChangeDetectorRef,
    protected dialogRef: MatDialogRef<MerchantDetailsComponent>

  ) { }

}

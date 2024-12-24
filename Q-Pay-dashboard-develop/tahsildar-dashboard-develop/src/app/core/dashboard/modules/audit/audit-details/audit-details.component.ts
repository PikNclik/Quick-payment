import { ChangeDetectorRef, Component, Inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  MatDialogRef,
  MAT_DIALOG_DATA,
  MatDialogModule
} from '@angular/material/dialog';
import { Audit } from 'src/app/models/data/audit.model';
import { MatButtonModule } from '@angular/material/button';
import { MatTabsModule } from '@angular/material/tabs';
import { SharedModule } from 'src/app/shared/modules/shared.module';

@Component({
  selector: 'app-audit-details',
  standalone: true,
  imports: [
    CommonModule,
    MatTabsModule,
    MatDialogModule,
    MatButtonModule,
    SharedModule
  ],
  templateUrl: './audit-details.component.html',
  styleUrls: ['./audit-details.component.scss']
})
export class AuditDetailsComponent {

  oldValues:any;
  newValues:any;
  oldValuesKeys:string[]=[];
  newValuesKeys:string[]=[];
  constructor(
    @Inject(MAT_DIALOG_DATA)
    public data: { audit: Audit }

  ) { 

  }
  ngOnInit(): void {
    console.log(this.data)
    this.oldValues=this.data.audit.old_values;
    this.newValues=this.data.audit.new_values;
    this.oldValuesKeys=Object.keys(this.oldValues);
    this.newValuesKeys=Object.keys(this.newValues);
  }

}

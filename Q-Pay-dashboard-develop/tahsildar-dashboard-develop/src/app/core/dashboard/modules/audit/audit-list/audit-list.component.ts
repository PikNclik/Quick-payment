import { DatePipe } from '@angular/common';
import { ChangeDetectorRef, Component } from '@angular/core';
import { finalize } from 'rxjs';
import {
  Transaction,
  transactionStatus,
} from 'src/app/models/data/transaction.model';
import { CmsListComponent } from 'src/app/shared/components/cms/cms-list/cms-list.component';
import { BaseCmsAction } from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { environment } from 'src/environments/environment';
import { AuditCmsService } from '../cms/audit-cms.service';
import { AuditService } from '../services/audit.service';
import { MatButtonModule } from '@angular/material/button';
import { Audit } from 'src/app/models/data/audit.model';
import { MatDialog } from '@angular/material/dialog';
import { AuditDetailsComponent } from '../audit-details/audit-details.component';

@Component({
  selector: 'app-audit-list',
  standalone: true,
  templateUrl: './audit-list.component.html',
  styleUrls: ['./audit-list.component.scss'],
  imports: [SharedModule, MatButtonModule, CmsListComponent],
  providers: [
    DatePipe,
    HttpService,
    ErrorService,
    AuditService,
    {
      provide: CmsService<AuditListComponent>,
      useClass: AuditCmsService,
    },
  ],
})
export class AuditListComponent {
  constructor(
    private datePipe: DatePipe,
    private cdr: ChangeDetectorRef,
    private errorService: ErrorService,
    private cmsService: CmsService<Transaction>,
    private auditService: AuditService,
    public dialog: MatDialog
  ) {
    this.onDataFetched();
    this.subscribeTableActions();
  }
  private subscribeTableActions(): void {
    this.cmsService.onRowAction.subscribe(action => {
      const { key, item } = action;
      switch (key) {
        case BaseCmsAction.details:
          this.showDetails(item);
          break;
      }
    });
  }
  private showDetails(audit: Audit): void {
    const dialogRef = this.dialog.open(AuditDetailsComponent, {
      maxWidth: '60vw',
      data: {
        audit: audit
      },
      width: '90vw'
    });

    dialogRef.afterClosed().subscribe((result: boolean) => {
      if (!result) return;


    });
  }
  private transformTransaction(audit: Audit): void {
    // Transform dates

    audit.created_at =
    this.datePipe.transform(
      audit.created_at,
      environment.datetimeFormat
    ) || '';
  
  }

  /**
   * handle fetched data
   */
  private onDataFetched(): void {
    this.cmsService.onDataFetched.subscribe((transactions) => {
      transactions.forEach((transaction) => {
        this.transformTransaction(transaction);
      });
    });
  }



}

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
import { TransactionsCmsService } from '../cms/transactions-cms.service';
import { TransactionService } from '../services/transaction.service';
import { MatButtonModule } from '@angular/material/button';
import { MatDialog } from '@angular/material/dialog';
import { TransactionDetailsComponent } from '../transaction-details/transaction-details.component';

@Component({
  selector: 'app-transactions-list',
  standalone: true,
  templateUrl: './transactions-list.component.html',
  styleUrls: ['./transactions-list.component.scss'],
  imports: [SharedModule, MatButtonModule, CmsListComponent],
  providers: [
    DatePipe,
    HttpService,
    ErrorService,
    TransactionService,
    {
      provide: CmsService<TransactionsListComponent>,
      useClass: TransactionsCmsService,
    },
  ],
})
export class TransactionsListComponent {
  constructor(
    private datePipe: DatePipe,
    private cdr: ChangeDetectorRef,
    private errorService: ErrorService,
    private cmsService: CmsService<Transaction>,
    private transactionService: TransactionService,
    public dialog: MatDialog
  ) {
    this.onDataFetched();
    this.subscribeTableActions();
  }

  private transformTransaction(transaction: Transaction): void {
    // Transform dates

    if (transaction.transaction_to_do != null){
      transaction.transaction_to_do.created_at =
        this.datePipe.transform(
          transaction.transaction_to_do?.created_at,
          environment.datetimeFormat
        ) || '';
    }
    transaction.amount = transaction.amount?.toLocaleString();
    transaction.created_at =
      this.datePipe.transform(
        transaction.created_at,
        environment.datetimeFormat
      ) || '';
    transaction.scheduled_date =
      this.datePipe.transform(
        transaction.scheduled_date,
        environment.datetimeFormat
      ) || '';
    transaction.expiry_date =
      this.datePipe.transform(
        transaction.expiry_date,
        environment.datetimeFormat
      ) || '';

    // Map status
    transaction.status = transactionStatus.get(+(transaction.status ?? '1'));

    // Recursively transform children
    if (transaction.children && transaction.children.length > 0) {
      transaction.children.forEach((child) => {
        this.transformTransaction(child);
      });
    }
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
  /**
   * subscribe cms table actions
   */
  private subscribeTableActions(): void {
    this.cmsService.onRowAction.subscribe((action) => {
      const { key, item } = action;
      switch (key) {
        case BaseCmsAction.details:
          this.showDetails(item);
          break;
        case BaseCmsAction.cancel:
          this.cancelTransaction(item);
          break;
      }
    });
  }
  private showDetails(transaction: Transaction): void {
    const dialogRef = this.dialog.open(TransactionDetailsComponent, {
      maxWidth: '80vw',
      data: {
        transaction: transaction
      },
      width: '90vw'
    });

  }

  /**
   * cancel Transaction
   * @param {Transaction} transaction
   */
  private cancelTransaction(transaction: Transaction): void {
    this.cmsService.loading.next(true);
    this.transactionService
      .cancelTransaction(transaction.id?.toString())
      .subscribe({
        next: (data) => {
          this.cmsService.loading.next(false);
          this.cdr.detectChanges();
          transaction = {
            ...transaction,
            status: transactionStatus.get(+(data.status ?? '1')),
          };
          this.cmsService.onRowUpdated.emit(transaction);
        },
        error: (error) => {
          this.cmsService.loading.next(false);
          this.errorService.showMessage(error?.message || error);
        },
      });
  }

  /**
   * handle select file to upload
   * @param {any} event input change event
   */
  public handleFileInput(event: any) {
    const file = event.srcElement.files[0];
    event.srcElement.value = null;
    this.cmsService.loading.next(true);
    this.transactionService
      .post('excel', this.transactionService.parseToFormData({ file: file }))
      .pipe(finalize(() => this.cmsService.loading.next(false)))
      .subscribe({
        next: (data) => {
          this.cmsService.onRefetchData.emit();
        },
        error: (error) => {
          this.cmsService.loading.next(false);
          this.errorService.showMessage(error?.message || error);
        },
      });
  }
}

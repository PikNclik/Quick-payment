import { Component } from '@angular/core';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { CmsListComponent } from 'src/app/shared/components/cms/cms-list/cms-list.component';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { TransactionToDoCmsService } from '../cms/transaction-to-do-cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { TransactionToDo } from "../../../../../models/data/transaction-to-do.model";
import { MatButtonModule } from "@angular/material/button";
import { finalize } from "rxjs";
import { TransactionToDoService } from "../services/transaction-to-do.service";
import { ErrorService } from "../../../../../shared/services/http/error.service";
import { DatePipe } from "@angular/common";
import { environment } from "../../../../../../environments/environment";
import { TransactionToDoFormService } from '../cms/transaction-to-do-form.service';
import { AuthService } from 'src/app/shared/services/auth.service';

@Component({
  selector: 'app-transaction-to-do-list',
  standalone: true,
  templateUrl: './transaction-to-do-list.component.html',
  styleUrls: ['./transaction-to-do-list.component.scss'],
  imports: [
    SharedModule,
    CmsListComponent,
    MatButtonModule,
  ],
  providers: [
    HttpService,
    ErrorService,
    TransactionToDoService,
    TransactionToDoFormService,
    DatePipe,
    {
      provide: CmsService<TransactionToDo>,
      useClass: TransactionToDoCmsService,
    },
  ],
})
export class TransactionToDoListComponent {
  showBarakaExternal = false;
  showBarakaInternal = false;
  showImport = false;
  permissionCategory = "Transaction to do";
  constructor(
    private cmsService: CmsService<TransactionToDo>,
    private transactionToDoService: TransactionToDoService,
    private errorService: ErrorService,
    private authService: AuthService,
    private datePipe: DatePipe

  ) {
    this.onDataFetched();
  }

  ngOnInit(): void {
    this.showBarakaExternal = this.authService.checkPermission(this.permissionCategory, "Albaraka external report");
    this.showBarakaInternal = this.authService.checkPermission(this.permissionCategory, "Albaraka internal report");
    this.showImport = this.authService.checkPermission(this.permissionCategory, "Import excel");
  }
  /**
   * handle fetched data
   */
  private onDataFetched(): void {
    this.cmsService.onDataFetched.subscribe(transactionToDos => {
      transactionToDos.forEach(transactionToDo => {
        transactionToDo.executedString = transactionToDo.executed ? "executed" : "not_executed"
        transactionToDo.date = this.datePipe.transform(transactionToDo.created_at, environment.dateFormat) ?? "";
        transactionToDo.time = this.datePipe.transform(transactionToDo.created_at, "hh:mm a") ?? "";
        transactionToDo.amount = transactionToDo.amount?.toLocaleString();
      });
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
    this.transactionToDoService.post('excel', this.transactionToDoService.parseToFormData({ 'file': file }))
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

  public getALBarakaExcelFile() {
    let endPoint= "export_albaraka_transactions";
      this.transactionToDoService.download(endPoint, "ALBaraka settlement files  "+new Date() , "zip")
        .subscribe();
  }
}

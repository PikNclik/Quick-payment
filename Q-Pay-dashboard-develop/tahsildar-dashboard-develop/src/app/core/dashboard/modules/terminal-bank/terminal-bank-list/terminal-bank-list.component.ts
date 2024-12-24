import { Component } from '@angular/core';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { CmsListComponent } from 'src/app/shared/components/cms/cms-list/cms-list.component';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { TerminalBankCmsService } from '../cms/terminal-bank-cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { DatePipe } from '@angular/common';
import { environment } from 'src/environments/environment';
import { SystemBankData } from "../../../../../models/data/system-bank-data.model";
import { TerminalBankFormService } from "../cms/terminal-bank-form.service";
import { TerminalBank } from 'src/app/models/data/terminal-bank.model';
import { BaseCmsAction } from 'src/app/shared/components/cms/config/cms.config';
import { CommissionComponent } from '../commission/commission.component';
import { MatDialog } from '@angular/material/dialog';

@Component({
  selector: 'app-terminal-bank-list',
  standalone: true,
  templateUrl: './terminal-bank-list.component.html',
  styleUrls: ['./terminal-bank-list.component.scss'],
  imports: [
    SharedModule,
    CmsListComponent,
  ],
  providers: [
    TerminalBankFormService,
    DatePipe,
    HttpService,
    {
      provide: CmsService<SystemBankData>,
      useClass: TerminalBankCmsService,
    },
  ],
})
export class TerminalBankListComponent {
  constructor(
    private datePipe: DatePipe,
    private cmsService: CmsService<TerminalBank>,
    public dialog: MatDialog
  ) {
    this.onDataFetched();
    this.subscribeTableActions();
  }

  /**
   * handle fetched data
   */
  private onDataFetched(): void {
    this.cmsService.onDataFetched.subscribe(banks => {
      banks.forEach(bank => {
        bank.created_at = this.datePipe.transform(bank.created_at, environment.datetimeFormat) || "";
        bank.activeString = bank.active ? 'Active' : 'Not Active';
      });
    });
  }

  /**
  * subscribe cms table actions
  */
  private subscribeTableActions(): void {
    this.cmsService.onRowAction.subscribe(action => {
      const { key, item } = action;
      switch (key) {
        case BaseCmsAction.internal_commission:
          this.showCommission(item, 'Internal');
          break;
        case BaseCmsAction.external_commission:
          this.showCommission(item, 'External');
          break;

      }
    });
  }
  private showCommission(terminalBank: TerminalBank, type: string): void {
    const dialogRef = this.dialog.open(CommissionComponent, {
      maxWidth: '60vw',
      width: '40vw',
      data: {
        terminalBankId: terminalBank.id,
        type: type
      }
    });

  }

}

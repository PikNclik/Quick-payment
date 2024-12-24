import { Component } from '@angular/core';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { CmsListComponent } from 'src/app/shared/components/cms/cms-list/cms-list.component';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { SystemBankDataCmsService } from '../cms/system-bank-data-cms.service';
import { SystemBankDataFormService } from '../cms/system-bank-data-form.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { DatePipe } from '@angular/common';
import { environment } from 'src/environments/environment';
import {SystemBankData} from "../../../../../models/data/system-bank-data.model";

@Component({
  selector: 'app-system-bank-data-list',
  standalone: true,
  templateUrl: './system-bank-data-list.component.html',
  styleUrls: ['./system-bank-data-list.component.scss'],
  imports: [
    SharedModule,
    CmsListComponent,
  ],
  providers: [
    DatePipe,
    HttpService,
    SystemBankDataFormService,
    {
      provide: CmsService<SystemBankData>,
      useClass: SystemBankDataCmsService,
    },
  ],
})
export class SystemBankDataListComponent {
  constructor(
    private datePipe: DatePipe,
    private cmsService: CmsService<SystemBankData>,
  ) {
    this.onDataFetched();
  }

  /**
   * handle fetched data
   */
  private onDataFetched(): void {
    this.cmsService.onDataFetched.subscribe(banks => {
      banks.forEach(bank => {
        bank.created_at = this.datePipe.transform(bank.created_at, environment.datetimeFormat) || "";
      });
    });
  }
}

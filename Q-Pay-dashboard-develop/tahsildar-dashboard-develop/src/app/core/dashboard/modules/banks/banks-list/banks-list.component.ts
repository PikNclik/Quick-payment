import { Component } from '@angular/core';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { CmsListComponent } from 'src/app/shared/components/cms/cms-list/cms-list.component';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { Bank } from 'src/app/models/data/bank.model';
import { BanksCmsService } from '../cms/banks-cms.service';
import { BanksFormService } from '../cms/banks-form.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { DatePipe } from '@angular/common';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-banks-list',
  standalone: true,
  templateUrl: './banks-list.component.html',
  styleUrls: ['./banks-list.component.scss'],
  imports: [
    SharedModule,
    CmsListComponent,
  ],
  providers: [
    DatePipe,
    HttpService,
    BanksFormService,
    {
      provide: CmsService<Bank>,
      useClass: BanksCmsService,
    },
  ],
})
export class BanksListComponent {
  constructor(
    private datePipe: DatePipe,
    private cmsService: CmsService<Bank>,
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
        bank.activeString = bank.active ? 'Active' : 'Not Active';
      });
    });
  }
}

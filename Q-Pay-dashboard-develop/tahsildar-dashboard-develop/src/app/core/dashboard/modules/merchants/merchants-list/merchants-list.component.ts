import { ChangeDetectorRef, Component, ViewChild } from '@angular/core';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { CmsListComponent } from 'src/app/shared/components/cms/cms-list/cms-list.component';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { DatePipe } from '@angular/common';
import { environment } from 'src/environments/environment';
import { MerchantsFormService } from '../cms/merchants-form.service';
import { MerchantsCmsService } from '../cms/merchants-cms.service';
import { Merchant } from 'src/app/models/data/merchant.model';
import { BaseCmsAction } from 'src/app/shared/components/cms/config/cms.config';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { MerchantService } from '../services/merchant.service';
import { finalize } from 'rxjs';
import { MatDialog } from "@angular/material/dialog";
import { User } from 'src/app/models/data/user.model';
import { MerchantDetailsComponent } from '../merchant-details/merchant-details.component';

@Component({
  selector: 'app-merchants-list',
  standalone: true,
  templateUrl: './merchants-list.component.html',
  styleUrls: ['./merchants-list.component.scss'],
  imports: [
    SharedModule,
    CmsListComponent,
  ],
  providers: [
    DatePipe,
    HttpService,
    MerchantService,
    MerchantsFormService,
    {
      provide: CmsService<Merchant>,
      useClass: MerchantsCmsService,
    },
  ],
})
export class MerchantsListComponent {

  constructor(
    private datePipe: DatePipe,
    private cdr: ChangeDetectorRef,
    private errorService: ErrorService,
    private merchantService: MerchantService,
    private cmsService: CmsService<Merchant>,
    public dialog: MatDialog
  ) {
    this.onDataFetched();
    this.subscribeTableActions();
  }

  /**
   * handle fetched data
   */
  private onDataFetched(): void {
    this.cmsService.onDataFetched.subscribe(merchants => {
      merchants.forEach(merchant => {
        merchant.created_at = this.datePipe.transform(merchant.created_at, environment.datetimeFormat) || "";
        merchant.activated_at = this.datePipe.transform(merchant.activated_at, environment.datetimeFormat) || "";
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
        case BaseCmsAction.details:
          this.showDetails(item);
          break;
        case BaseCmsAction.block:
        case BaseCmsAction.unBlock:
          this.blockUser(item);
          break;
      }
    });
  }
  private showDetails(merchant: Merchant): void {
    const dialogRef = this.dialog.open(MerchantDetailsComponent, {
      maxWidth: '80vw',
      data: {
        merchant: merchant
      },
      width: '90vw'
    });

  }

  /**
   * block/un-block user
   *
   * @param {Merchant} user
   */
  private blockUser(user: Merchant): void {
    this.cmsService.loading.next(true);
    this.merchantService.blockUser(user)
      .subscribe({
        next: (data) => {
          this.cmsService.loading.next(false);
          this.cdr.detectChanges();
          user = { ...user, active: data.active };
          this.cmsService.onRowUpdated.emit(user);
        },
        error: (error) => {
          this.cmsService.loading.next(false);
          this.errorService.showMessage(error?.message || error)
        },
      });
  }
}

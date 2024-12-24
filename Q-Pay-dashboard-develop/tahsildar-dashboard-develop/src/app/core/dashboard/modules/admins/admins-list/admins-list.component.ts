import { CommonModule } from '@angular/common';
import { ChangeDetectorRef, Component } from '@angular/core';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { CmsListComponent } from 'src/app/shared/components/cms/cms-list/cms-list.component';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { DatePipe } from '@angular/common';
import { environment } from 'src/environments/environment';
import { AdminsFormService } from '../cms/admins-form.service';
import { AdminsCmsService } from '../cms/admins-cms.service';
import { BaseCmsAction } from 'src/app/shared/components/cms/config/cms.config';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { AdminService } from '../services/admin.service';
import { Admin } from 'src/app/models/data/admin.model';

@Component({
  selector: 'app-admins-list',
  standalone: true,
  imports: [
    CommonModule,
    SharedModule,
    CmsListComponent,
  ],
  providers: [
    DatePipe,
    HttpService,
    AdminService,
    AdminsFormService,
    {
      provide: CmsService<Admin>,
      useClass: AdminsCmsService,
    },
  ],
  templateUrl: './admins-list.component.html',
  styleUrls: ['./admins-list.component.scss']
})
export class AdminsListComponent {
  constructor(
    private datePipe: DatePipe,
    private cdr: ChangeDetectorRef,
    private errorService: ErrorService,
    private adminService: AdminService,
    private cmsService: CmsService<Admin>,
  ) {
    this.onDataFetched();
  }
  
  /**
   * handle fetched data
   */
  private onDataFetched(): void {
    this.cmsService.onDataFetched.subscribe(admins => {
      admins.forEach(admin => {
        admin.created_at = this.datePipe.transform(admin.created_at, environment.datetimeFormat) || "";
      });
    });
  }
}

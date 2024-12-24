import {Component} from '@angular/core';
import {SharedModule} from 'src/app/shared/modules/shared.module';
import {CmsListComponent} from 'src/app/shared/components/cms/cms-list/cms-list.component';
import {CmsService} from 'src/app/shared/components/cms/services/cms.service';
import {CustomerCmsService} from '../cms/customer-cms.service';
import {HttpService} from 'src/app/shared/services/http/http.service';;
import {Customer} from "../../../../../models/data/customer.model";

@Component({
  selector: 'app-customers-list',
  standalone: true,
  templateUrl: './customer-list.component.html',
  styleUrls: ['./customer-list.component.scss'],
  imports: [
    SharedModule,
    CmsListComponent,
  ],
  providers: [
    HttpService,
    {
      provide: CmsService<Customer>,
      useClass: CustomerCmsService,
    },
  ],
})
export class CustomerListComponent {
}

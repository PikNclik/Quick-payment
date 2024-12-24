import { CommonModule } from '@angular/common';
import { ChangeDetectorRef, Component } from '@angular/core';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { CmsListComponent } from 'src/app/shared/components/cms/cms-list/cms-list.component';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { DatePipe } from '@angular/common';
import { environment } from 'src/environments/environment';
import { RolesFormService } from '../cms/roles-form.service';
import { RolesCmsService } from '../cms/roles-cms.service';
import { BaseCmsAction } from 'src/app/shared/components/cms/config/cms.config';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { RoleService } from '../services/role.service';
import { Role } from 'src/app/models/data/role.model';
import { MatDialog } from '@angular/material/dialog';
import { RolePermissionsComponent } from '../role-permissions/role-permissions.component';

@Component({
  selector: 'app-roles-list',
  standalone: true,
  imports: [
    CommonModule,
    SharedModule,
    CmsListComponent,
  ],
  providers: [
    DatePipe,
    HttpService,
    RoleService,
    RolesFormService,
    {
      provide: CmsService<Role>,
      useClass: RolesCmsService,
    },
  ],
  templateUrl: './roles-list.component.html',
  styleUrls: ['./roles-list.component.scss']
})
export class RolesListComponent {
  constructor(
    private datePipe: DatePipe,
    private cmsService: CmsService<Role>,
    public dialog: MatDialog
  ) {

    this.subscribeTableActions();
  }

  /**
* subscribe cms table actions
*/
  private subscribeTableActions(): void {
    this.cmsService.onRowAction.subscribe(action => {
      const { key, item } = action;
      switch (key) {
        case BaseCmsAction.permissions:
          this.showPermissions(item);
          break;
      }
    });
  }

  private showPermissions(role: Role): void {
    const dialogRef = this.dialog.open(RolePermissionsComponent, {
      maxWidth: '60vw',
      data: {
        roleId: role.id
      },
      width: '90vw'
    });

    dialogRef.afterClosed().subscribe((result: boolean) => {
      if (!result) return;


    });
  }
}

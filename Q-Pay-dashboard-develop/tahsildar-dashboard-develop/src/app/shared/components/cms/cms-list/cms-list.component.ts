import { Component } from '@angular/core';
import { BaseCmsAction, BaseCmsConfig, BaseCmsEvent, EntityPageType } from '../config/cms.config';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { BaseCmsTableComponent } from '../base-table/base-table.component';
import { FiltersComponent } from '../filters/filters.component';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { MatTooltipModule } from '@angular/material/tooltip';
import { ActivatedRoute, Router } from '@angular/router';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { CmsUpdateService } from '../dialogs/cms-update/cms-update.service';
import { ConfirmDialogService } from '../../confirm-dialog/confirm-dialog.service';
import { CmsCreateService } from '../dialogs/cms-create/cms-create.service';
import { CmsService } from '../services/cms.service';
import { HttpService } from 'src/app/shared/services/http/http.service';
import {finalize} from "rxjs";

@Component({
  selector: 'app-cms-list',
  standalone: true,
  templateUrl: './cms-list.component.html',
  styleUrls: ['./cms-list.component.scss'],
  imports: [
    SharedModule,
    MatIconModule,
    MatButtonModule,
    MatTooltipModule,
    FiltersComponent,
    BaseCmsTableComponent,
  ],
  providers: [
    HttpService,
    CmsUpdateService,
    CmsCreateService,
    ConfirmDialogService,
  ]
})
export class CmsListComponent<T> {
  constructor(
    private router: Router,
    private route: ActivatedRoute,
    public cmsService: CmsService<T>,
    private errorService: ErrorService,
    private cmsCreateService: CmsCreateService<T>,
    private cmsUpdateService: CmsUpdateService<T>,
    private confirmDialogService: ConfirmDialogService,
  ) { }

  /**
   * @param {BaseCmsConfig<T>} cmsConfig object contains all base-table config like columns, actions and server end-point
   */
  public cmsConfig: BaseCmsConfig<T> = this.cmsService.cmsConfig;

  /**
   * handle row action event
   * @param {BaseCmsEvent<T>} event row action event
   */
  public emitRowAction(event: BaseCmsEvent<T>): void {
    const { key, item } = event;
    switch (key) {
      case BaseCmsAction.view:
        this.viewItem(item);
        break;
      case BaseCmsAction.edit:
        this.editItem(item);
        break;
      case BaseCmsAction.delete:
        this.deleteItem(item);
        break;
      default:
        this.cmsService.onRowAction.emit({ key, item });
    }
  }

  /**
   * open modal to create new item
   */
  public newItem(): void {
    if (this.cmsConfig.entityPageType == EntityPageType.screen) {
      // navigate to `new-entity` screen
      this.router.navigate(['new'], { relativeTo: this.route });
    } else if (this.cmsConfig.entityPageType == EntityPageType.modal) {
      // open `new-entity` modal
      if (!this.cmsConfig.formConfig) return;
      const formConfig = this.cmsConfig.formConfig();
      this.cmsCreateService.openDialog(formConfig).subscribe({
        next: (success) => {
          // refresh data after insert
          if (success) this.cmsService.onRefetchData.emit();
        },
      });
    }
  }

  /**
   * navigate to view screen
   * @param {T} item
   */
  private viewItem(item: T) {
    const id = item["_id"] || item["id"] || "";
    if (id) this.router.navigate(['view', id], { relativeTo: this.route });
  }

  /**
   * update item data
   * @param {T} item
   */
  private editItem(item: T): void {
    const id = item["_id"] || item["id"] || "";
    if (this.cmsConfig.entityPageType == EntityPageType.modal) {
      // open `edit-entity` form as modal
      if (!this.cmsConfig.formConfig) return;
      this.cmsUpdateService.openDialog(`${this.cmsConfig.endPoint}/${id}`, this.cmsConfig.formConfig).subscribe({
        next: (success) => {
          if (success) {
            // refresh data after edit
            this.cmsService.onRefetchData.emit();
          }
        },
      });
    } else {
      // navigate to `edit-entity` screen
      this.router.navigate(['edit', id], { relativeTo: this.route });
    }
  }

  /**
   * send request to server to remove the item
   * @param {T} item
   */
  private deleteItem(item: T): void {
    this.confirmDialogService.open('delete', 'the_item_will_deleted').subscribe(result => {
      if (result) {
        const id = item["_id"] || item["id"] || "";
        this.cmsService.loading.next(true);
        this.cmsService.httpService.delete(`${this.cmsConfig.endPoint}/${id}`).subscribe({
          next: () => {
            // re-fetch data
            this.cmsService.onRefetchData.emit();
          },
          error: (error) => {
            this.errorService.showMessage(error?.message || error);
            this.cmsService.loading.next(false);
          }
        });
      }
    });
  }

  export() {
    const filename = `Transaction ${new Date().toDateString()} ${Date.now()}`;
    this.cmsService.loading.next(true);
    this.cmsService.httpService.download(
      `${this.cmsConfig.endPoint}/excel`,
      filename,
      "xlsx",
      this.cmsService.filterObject.getValue()
    )
      .pipe(finalize(() => {
        this.cmsService.loading.next(false);
      }))
      .subscribe(
        {
          next: () => {
            this.errorService.showMessage("Success");
          },
          error: (error) => {
            this.errorService.showMessage(error?.message || error);
          }
        }
      );
  }
}

import { ChangeDetectorRef, Component, EventEmitter, OnInit, Output } from '@angular/core';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { ListResponse } from 'src/app/models/responses/list.response';
import { environment } from 'src/environments/environment';
import { TranslationService } from 'src/app/shared/services/translation.service';
import { BaseCmsEvent, BaseCmsConfig, CellType, BaseCmsAction } from '../config/cms.config';
import { CmsService } from '../services/cms.service';
import { SpecialLabels } from '../config/cms.config';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { BaseCmsPropertyKeyPipe } from 'src/app/shared/pipes/base-cms.property-key.pipe';
import { MatPaginatorModule } from '@angular/material/paginator';
import { MatIconModule } from '@angular/material/icon';
import { MatMenuModule } from '@angular/material/menu';
import { MatButtonModule } from '@angular/material/button';
import { MatSortModule } from '@angular/material/sort';
import { MatDialogModule } from '@angular/material/dialog';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { finalize } from 'rxjs';
import { MatTooltipModule } from '@angular/material/tooltip';

@Component({
  selector: 'app-base-table',
  templateUrl: './base-table.component.html',
  styleUrls: [
    './base-table.component.scss',
    './base-table.columns.scss'
  ],
  standalone: true,
  imports: [
    BaseCmsPropertyKeyPipe,
    MatProgressBarModule,
    MatPaginatorModule,
    MatTooltipModule,
    MatButtonModule,
    MatDialogModule,
    MatTableModule,
    MatIconModule,
    MatMenuModule,
    MatSortModule,
    SharedModule,
  ],
  providers: [
    HttpService,
  ]
})
export class BaseCmsTableComponent<T> implements OnInit {
  public tableDataSource = new MatTableDataSource<T>([]);
  public dataList: T[] = [];
  public totalRows: number = 0;
  public page: number = 0;
  public perPage: number = environment.perPage;
  public displayedColumns: string[] = [];
  public specialLabels = SpecialLabels;
  public cellType = CellType;

  private sortColumn?: string;
  private sortType?: string;

  constructor(
    public translationService: TranslationService,
    private errorService: ErrorService,
    public cmsService: CmsService<T>,
    private cdr: ChangeDetectorRef,
  ) { }

  /**
   * @param {BaseCmsConfig<T>} cmsConfig object contains all base-table config like columns, actions and server end-point
   */
  public cmsConfig: BaseCmsConfig<T> = this.cmsService.cmsConfig;

  /**
   * @param {EventEmitter<BaseCmsEvent<T>>} onRowAction event emitter for some cmsConfig.actions
   */
  @Output() onRowAction: EventEmitter<BaseCmsEvent<T>> = new EventEmitter();

  ngOnInit(): void {
    this.subscribeCmsEvents();
    this.initTableColumns();
    this.getList();
  }

  /**
   * subscribe @param cmsService events
   */
  private subscribeCmsEvents(): void {
    this.cmsService.onRefetchData.subscribe(() => {
      this.page = 0;
      this.getList();
    });

    this.cmsService.onRowUpdated.subscribe((item) => {
      this.updateRow(item);
    });
  }

  /**
   * initialize table columns
   */
  private initTableColumns(): void {
    this.displayedColumns.length = 0;
    // add actions to displayedColumns if not exists
    if (this.cmsConfig.actions && this.cmsConfig.actions.length != 0 && !this.cmsConfig.columns.find(e => e.key == 'actions')) {
      this.cmsConfig.columns.push({ key: 'actions', name: 'actions', type: CellType.actions });
    }
    this.displayedColumns = this.cmsConfig.columns.map(e => e.key);
  }

  /**
   * get data list from server
   */
  private getList(): void {
    this.cmsService.loading.next(true);
    const queryParams = this.queryParams();
    this.tableDataSource = new MatTableDataSource<T>([]);
    this.cmsService.httpService.get<ListResponse<T>>(this.cmsConfig.endPoint, queryParams)
      .pipe(finalize(() => this.cmsService.loading.next(false)))
      .subscribe({
        next: (result) => {
          if (this.cmsConfig.factory) {
            // get new instance for each fetched data-item
            this.dataList = (result.data || []).map(e => this.cmsConfig.factory!(e));
          } else {
            this.dataList = result.data || [];
          }
          this.cmsService.onDataFetched.emit(this.dataList);
          this.totalRows = result.total || 0;
          this.tableDataSource = new MatTableDataSource<T>(this.dataList);
        },
        error: (error) => { this.errorService.showMessage(error?.message || error); },
      });
  }

  /**
   * sorting table data
   *
   * @param event sort event
   */
  public sort(event: any): void {
    this.sortColumn = event.direction != '' ? event.active : '';
    this.sortType = event.direction;
    this.page = 0;
    this.getList();
  }

  /**
   * get data with specific page
   *
   * @param event pagination event
   */
  public onPageChanged(event: any): void {
    this.page = event.pageIndex;
    this.perPage = event.pageSize;
    this.getList();
  }

  /**
   * handle cell click event
   *
   * @param {any} key element key
   * @param {T} item element
   */
  public emitCellAction(key: any, item: T): void {
    this.cmsService.onCellAction.emit({ key, item });
  }

  /**
   * handle row action event
   * @param {BaseCmsAction} action action key
   * @param {T} item element
   */
  public emitRowAction(action: BaseCmsAction, item: T): void {
    this.onRowAction.emit({ key: action, item });
  }

  /**
   * mapping query params which will sent to server to fetch data
   *
   * @returns {object} query params object
   */
  private queryParams(): object {
    const page = this.page + 1;
    const queryParams = {
      page,
      per_page: this.perPage,
      ...this.cmsService.filterObject.getValue(),
    };

    if (this.sortColumn && this.sortType) {
      queryParams['sort_keys[]'] = this.sortColumn;
      queryParams['sort_dir[]'] = this.sortType;
    }

    return queryParams;
  }

  /**
   * update row item with new data
   *
   * @param {T} data object with new data
   */
  public updateRow(data: T): void {
    const index = this.dataList.findIndex(e => e["id"] == data["id"]);
    if (index != -1) {
      const list = [...this.tableDataSource.data];
      list[index] = data;
      this.tableDataSource.data = list;
      this.cdr.detectChanges();
    }
  }
}

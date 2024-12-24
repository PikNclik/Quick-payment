import {
  ChangeDetectorRef,
  Component,
  EventEmitter,
  OnInit,
  Output,
} from '@angular/core';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { ListResponse } from 'src/app/models/responses/list.response';
import { environment } from 'src/environments/environment';
import { TranslationService } from 'src/app/shared/services/translation.service';
import {
  BaseCmsEvent,
  BaseCmsConfig,
  CellType,
  BaseCmsAction,
} from '../config/cms.config';
import {
  animate,
  state,
  style,
  transition,
  trigger,
} from '@angular/animations';
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
import { MatCardModule } from '@angular/material/card';

interface TableRow {
  id: string;
  expanded?: boolean;
  children?: TableRow[];
}

@Component({
  selector: 'app-base-table',
  templateUrl: './base-table.component.html',
  styleUrls: ['./base-table.component.scss', './base-table.columns.scss'],
  standalone: true,
  animations: [
    trigger('detailExpand', [
      state('collapsed,void', style({ height: '0px', minHeight: '0' })),
      state('expanded', style({ height: '*' })),
      transition(
        'expanded <=> collapsed',
        animate('225ms cubic-bezier(0.4, 0.0, 0.2, 1)')
      ),
    ]),
  ],
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
    MatCardModule,
  ],
  providers: [HttpService],
})
export class BaseCmsTableComponent<T> implements OnInit {
  public tableDataSource = new MatTableDataSource<T>([]);
  public dataList: T[] = [];
  public totalRows: number = 0;
  public page: number = 0;
  public perPage: number = environment.perPage;
  public displayedColumns: string[] = [];
  childrenDisplayedColumns: string[] = [];
  public specialLabels = SpecialLabels;
  public cellType = CellType;
  expandedElement: T | null = null;
  expandedRows = new Set<any>();

  private sortColumn?: string;
  private sortType?: string;

  constructor(
    public translationService: TranslationService,
    private errorService: ErrorService,
    public cmsService: CmsService<T>,
    private cdr: ChangeDetectorRef
  ) {}

  public cmsConfig: BaseCmsConfig<T> = this.cmsService.cmsConfig;

  @Output() onRowAction: EventEmitter<BaseCmsEvent<T>> = new EventEmitter();

  ngOnInit(): void {
    this.subscribeCmsEvents();
    this.initTableColumns();
    this.getList();
  }

  toggleRow(row: T) {
    this.expandedElement = this.expandedElement === row ? null : row;
    this.cdr.detectChanges();
  }

  rowHasDetails = (row: TableRow) => {
    return row.children && row.children.length > 0;
  };

  rowIsExpanded = (row: T) => {
    return this.expandedElement === row;
  };

  toggleExpand(row: any): void {
    this.emitRowAction(BaseCmsAction.details,row)
    if (this.isExpanded(row)) {
      this.expandedRows.delete(row);
    } else {
      this.expandedRows.add(row);
    }
  }

  isExpanded(row: any): boolean {
    return this.expandedRows.has(row);
  }

  private subscribeCmsEvents(): void {
    this.cmsService.onRefetchData.subscribe(() => {
      this.page = 0;
      this.getList();
    });

    this.cmsService.onRowUpdated.subscribe((item) => {
      this.updateRow(item);
    });
  }

  private initTableColumns(): void {
    this.displayedColumns.length = 0;

    // this.displayedColumns.push('expandIcon');

    if (
      this.cmsConfig.actions &&
      this.cmsConfig.actions.length != 0 &&
      !this.cmsConfig.columns.find((e) => e.key == 'actions')
    ) {
      this.cmsConfig.columns.unshift({
        key: 'actions',
        name: 'actions',
        type: CellType.actions,
      });
    }
    this.displayedColumns.push(
      'expandIcon',
      ...this.cmsConfig.columns.map((e) => e.key)
    );
  }

  private getList(): void {
    this.cmsService.loading.next(true);
    const queryParams = this.queryParams();
    this.tableDataSource = new MatTableDataSource<T>([]);
    this.cmsService.httpService
      .get<ListResponse<T>>(this.cmsConfig.endPoint, queryParams)
      .pipe(finalize(() => this.cmsService.loading.next(false)))
      .subscribe({
        next: (result) => {
          if (this.cmsConfig.factory) {
            this.dataList = (
              result.data?.map((data) => ({ ...data, parent: true })) || []
            ).map((e) => this.cmsConfig.factory!(e));
          } else {
            this.dataList =
              result.data?.map((data) => ({ ...data, parent: true })) || [];
          }
          this.cmsService.onDataFetched.emit(this.dataList);
          this.totalRows = result.total || 0;
          this.tableDataSource = new MatTableDataSource<T>(this.dataList);
        },
        error: (error) => {
          this.errorService.showMessage(error?.message || error);
        },
      });
  }

  public sort(event: any): void {
    this.sortColumn = event.direction != '' ? event.active : '';
    this.sortType = event.direction;
    this.page = 0;
    this.getList();
  }

  public onPageChanged(event: any): void {
    this.page = event.pageIndex;
    this.perPage = event.pageSize;
    this.getList();
  }
  isTopLevel(row: any): boolean {
    return !row.parent;
  }
  public emitCellAction(key: any, item: T): void {
    this.cmsService.onCellAction.emit({ key, item });
  }

  public emitRowAction(action: BaseCmsAction, item: T): void {
    this.onRowAction.emit({ key: action, item });
  }

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

  public updateRow(data: T): void {
    const index = this.dataList.findIndex((e) => e['id'] == data['id']);
    if (index != -1) {
      const list = [...this.tableDataSource.data];
      list[index] = data;
      this.tableDataSource.data = list;
      this.cdr.detectChanges();
    }
  }
}

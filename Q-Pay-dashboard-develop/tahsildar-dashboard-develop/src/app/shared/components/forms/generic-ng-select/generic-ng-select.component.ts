import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { NgSelectModule } from '@ng-select/ng-select';
import { finalize } from 'rxjs';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { FormNgSelectConfig } from '../config/forms.config';


@Component({
  selector: 'app-generic-ng-select',
  standalone: true,
  templateUrl: './generic-ng-select.component.html',
  styleUrls: ['./generic-ng-select.component.scss'],
  imports: [
    FormsModule,
    SharedModule,
    NgSelectModule,
  ],
  providers: [
    HttpService,
  ]
})
export class GenericNgSelectComponent<T> implements OnInit {
  @Input() config!: FormNgSelectConfig<T>
  @Input() initialItems: T[] = [];
  @Input() selectedItems: any[] = [];
  @Output() selectedItemsChange = new EventEmitter<any[]>();

  public loading: boolean = false;
  public allItems: any[] = [];
  public items: any[] = [];
  constructor(private httpService: HttpService) { }

  ngOnInit(): void {
    this.getData();
    this.config.refresh?.subscribe(() => this.getData('', true));
  }

  /**
   * search for data
   *
   * @param {string} query filter query
   */
  public async getData(query: string = '', clear: boolean = false): Promise<void> {
    if (this.config.searchLocally == true && this.allItems.length != 0) {
      this.searchLocally(query);
      return;
    }

    this.loading = true;
    if (clear) this.selectedItems = [];
    const queryParams = this.config.queryParams ? `&${this.config.queryParams}` : '';
    this.httpService.get<any>(`${this.config.endPoint}?search=${query}${queryParams}`)
      .pipe(finalize(() => this.loading = false))
      .subscribe({
        next: (data) => {
          // add selected items to suggestions
          if (this.config.mappingResponse) {
            data = this.config.mappingResponse(data);
          }

          data = this.initialzeSelectedItems(data || []);
          if (this.config.factory) {
            this.items = (data || []).map((e: any) => this.config.factory!(e));
          } else {
            this.items = (data || []);
          }
          this.allItems = [...this.items];
        },
      })
  }

  /**
   * To turn off client search
   * @returns {boolean} true
   */
  searchFn(): boolean {
    return true;
  }

  /**
   * filter items locally
   */
  private searchLocally(query: string = ''): void {
    const items = this.allItems.filter(e => e[this.config.bindLabel].toLocaleLowerCase().includes(query.toLocaleLowerCase()));
    this.items = items;
  }

  /**
   * Add selected items to suggestions
   */
  public initialzeSelectedItems(list: T[]): T[] {
    const items = [...list];
    (this.config.initialItems?.() || this.initialItems).forEach(selectedItem => {
      if (selectedItem && !list.find(item => item[this.config.bindValue] == selectedItem?.[this.config.bindValue])) {
        items.push(selectedItem);
      }
    });
    return items;
  }
}

import { EventEmitter, Injectable } from '@angular/core';
import { BaseCmsConfig, BaseCmsEvent } from '../config/cms.config';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { FilterSchema } from '../filters/config/filter.iterface';
import { BehaviorSubject } from 'rxjs';

@Injectable()
export abstract class CmsService<T> {
  constructor(public httpService: HttpService) { }

  /**
   * @return {BaseCmsConfig<T>} object contains all base-table config like columns, actions and server end-point
   */
  abstract cmsConfig: BaseCmsConfig<T>;

  /**
  * @param {EventEmitter<T[]>} onDataFetched event emitter to notify parent that new data is fetched from server
  * it used to modify the list like pipe date or edit some element in the list
  */
  public onDataFetched: EventEmitter<T[]> = new EventEmitter();


  /**
   * @param {EventEmitter<BaseCmsEvent<T>>} onRowAction event emitter for some cmsConfig.actions
   */
  public onRowAction: EventEmitter<BaseCmsEvent<T>> = new EventEmitter();


  /**
   * @param {EventEmitter<BaseCmsEvent<T>>} onCellAction event emitter for some cell event in base-table
   */
  public onCellAction: EventEmitter<BaseCmsEvent<T>> = new EventEmitter();


  /**
   * @param {EventEmitter} onRefetchData event emitter to call fetch-data method
   */
  public onRefetchData: EventEmitter<unknown> = new EventEmitter();


  /**
   * @param {EventEmitter<T>} onRowUpdated event emitter which used to send data from cms-parent to cms-table to update some row
   */
  public onRowUpdated: EventEmitter<T> = new EventEmitter();


  /**
   * @param {BehaviorSubject<any>} filterObject cms filters value
   */
  public filterObject: BehaviorSubject<any> = new BehaviorSubject({});


  /**
   * @param {BehaviorSubject<boolean>} loading event emitter for display progressBar while loading data
   *
   * this emit by parent and the cms-list will handle the values
   */
  public loading: BehaviorSubject<boolean> = new BehaviorSubject(false);


  /**
   * @returns {FilterSchema | undefined} Filter Configuration
   */
  filterSchema?: FilterSchema

  /**
   * handle filter event
   *
   * @param event filter inputs value
   */
  public onFilterApplied(event: any) {
    this.filterObject.next(event);
    this.onRefetchData.emit();
  }
}

import { FormConfig } from "src/app/shared/components/forms/config/forms.config";

export enum CellType {
  /**
   * is value is found in your `i18n/lang.json`
   */
  i18n,

  /**
   * is cell is one of SpecialLabels
   */
  special,

  /**
   * cell for display actions
   * this type is added automatically in base-table.ts
   */
  actions,

  /**
   * render as mat icon
   */
  matIcon,

  /**
   * none of above
   */
  default,
}

export enum BaseCmsAction { view, edit, delete, block, unBlock, cancel }

/**
 * cms event model
 */
export interface BaseCmsEvent<T> {
  key: any;
  item: T;
}

export interface BaseCmsActionConfig {
  /**
   * action id, it should be unique
   */
  action: BaseCmsAction;

  /**
   * displayed label, it will translated from `i18n/lang.json` inside cms-table automatically
   *
   * so you can pass it as you declare it in `i18n/lang.json`
   */
  label: string;

  /**
   * label color.
   *
   * it should be one of `primary`, `warn`, `danger`
   */
  color?: string;

  /**
   * condition to show/hide the action
   * @example
   * ```
   * visible: (item: any) => item.id != null,
   * ```
   * or
   * @example
   * ```
   * visible: () => someCondition == true,
   * ```
   *
   * @param {any} item row data in the table
   * @returns {boolean}
   */
  visible?: (item: any) => boolean;

  /**
   * mat-icon name
   */
  icon?: string;
}

export enum SpecialLabels { Image }

export interface BaseCmsColumn {
  /**
   * column display name
   */
  name: string;

  /**
   * name of key of the actual object data
   */
  key: string;

  /**
   * is cell is one of SpecialLabels
   *
   * be sure to set `type: CellType.special`
   * @example
   * ```
   * type: CellType.special,
   * special: SpecialLabels.Image,
   * ```
   */
  special?: SpecialLabels,

  /**
   * is cell is clickable
   */
  clickable?: boolean,

  /**
   * type of cell
   */
  type?: CellType,

  /**
   * can a column be sorted?
   */
  isSortable?: boolean;

  /**
   * sorting key which will sent to server
   */
  sortKey?: string;

  /**
   * css class name
   */
  cssClass?: string;
}

export interface BaseCmsConfig<T> {
  /**
   * api which called in table to get data
   */
  endPoint: string;

  /**
   * table columns
   */
  columns: BaseCmsColumn[];

  /**
   * table actions for each row
   */
  actions?: BaseCmsActionConfig[];

  /**
   * enable pagination
   */
  pagination?: boolean;

  /**
   * open modal or screen to create new entity
   */
  entityPageType?: EntityPageType;

  /**
   * condition to view fab-button to create new entity
   * @example
   * ```
   * canAddNewEntity: () => localUser.role == 'admin',
   * ```
   * @returns {boolean}
   */
  canAddNewEntity?: () => boolean;

  /**
   * create new instance from fetched data (used when `T` is class instead of interface)
   * @example
   * ```
   * factory: (item: any) => new Entity(item),
   * ```
   * @param item data which will displayed in each table row
   * @returns {T} new instance
   */
  factory?: (item: any) => T;

  /**
   * generic form config to create/update entity if your `entityPageType` is `modal`
   * @param {T | undefined} item row data which used to edit, return `undefined` in create event,
   * this will help you inject item data in the edit-form.
   * @returns {FormConfig<T>}
   */
  formConfig?: (item?: T) => FormConfig<T>;

  exportable?: boolean;
}

/**
 *  open modal or screen to create/edit new entity
 */
export enum EntityPageType { modal, screen };

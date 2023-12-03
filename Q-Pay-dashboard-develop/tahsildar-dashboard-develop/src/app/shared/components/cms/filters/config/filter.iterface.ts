import { Observable } from "rxjs";
import { FormNgSelectConfig } from "../../../forms/config/forms.config";

/**
 * Filter Model
 * Declare all params you want to pass to filters component
 */
export interface FilterSchema {
  /**
   * @param {boolean | undefined} query general search
   */
  query?: boolean;

  /**
   * @param {FilterInterface[]} inputs filter inputs
   */
  inputs: FilterInterface[];

  /**
   * @param {object} staticData send some data in filters without displayed to user.
   */
  staticData?: object;
}

/**
 * Model of Filter input
 */
export interface FilterInterface {
  /**
   * @param {string} key filter key
   */
  key: string;

  /**
   * @param {string} label displayed label
   */
  label: string;

  /**
   * @param {any | undefined} value filter value
   */
  value?: any;

  /**
   * @param {FilterStrategies} strategy filter strategy (used with inputType='number')
   */
  strategy?: FilterStrategies;

  /**
   * @param {FilterInputType} inputType type of filter input
   */
  inputType: FilterInputType;

  /**
   * @param {FilterSelectOption[] | undefined} options mat-select options (used with inputType='select' or inputType='multi_select')
   */
  options?: FilterSelectOption[];

  /**
   * @param {boolean | undefined} loading display progress-bar as input suffix
   */
  loading?: boolean;

  /**
   * @param {boolean | undefined} with_strategies display mat-select inside input (used with inputType='number')
   */
  with_strategies?: boolean;

  /**
   * ng-select config
   */
  ngSelectConfig?: () => FormNgSelectConfig<any>;

  /**
   * get mat-select form server or localStorage
   * @example
   * ```
   * loadOptions: <Entity>() => httpService.get('/list'),
   * ```
   * or
   * @example
   * ```
   * loadOptions: <Entity>() => JSON.parse(localStorage.getItem("list")),
   * ```
   */
  loadOptions?: (<X>() => Observable<X[]> | X[]);
}

/**
 * Filter on value (equal, less than or larger than)
 */
export enum FilterStrategies {
  gt = "GT",
  lt = "LT",
  eq = "EQ",
}

/**
 * Filter input type
 * filter component depending on these types to display the input (input, mat-date-picker, mat-select)
 */
export enum FilterInputType {
  text = 'text',
  email = 'email',
  phone = 'phone',
  number = 'number',
  date = 'date',
  select = 'select',
  multi_select = 'multi_select',
  ng_select = 'ng_select',
}

/**
 * Filter on option in array
 */
export class FilterSelectOption {
  public value!: any;
  public label!: string;

  constructor(object: { value: any, label?: string }) {
    Object.entries(object).forEach(e => {
      this[e[0]] = e[1];
    });
  }
}

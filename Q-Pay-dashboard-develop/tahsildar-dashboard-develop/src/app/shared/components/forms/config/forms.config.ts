import { EventEmitter } from "@angular/core";
import { Validator, ValidatorFn, AsyncValidator, AsyncValidatorFn, FormGroup } from "@angular/forms";
import { Observable } from "rxjs";

/**
 * generic form config
 */
export interface FormConfig<T> {
  /**
   * displayed title
   */
  title?: string;

  /**
   * formGroup which user in generic-form-builder
   */
  formGroup?: FormGroup;

  /**
   * api which called in create/edit
   */
  endPoint: string;

  /**
   * form fields config
   */
  formFields: FormFieldData[];

  /**
   * send request as FormData
   */
  parseToFormData?: boolean;

  /**
   * append data with formFields in request
   */
  staticData?: FormStaticData[];

  /**
   * display `button` to submit form data as http request.
   *
   * pass `false` when you add/edit entity in modal mode.
   */
  submitButton?: boolean;
}

/**
 * mat-form-field config
 */
export interface FormFieldData {
  /**
   * displayed label for input
   */
  label: string;

  /**
   * matInput type
   */
  inputType: FormInputType;

  /**
   * formControl name
   */
  formControlName: string;

  /**
   * formField validators
   */
  validators: (any | Validator | ValidatorFn)[];

  /**
   * async formField validators
   */
  asyncValidators?: (any | AsyncValidator | AsyncValidatorFn)[];

  /**
   * default value which will filled in the input
   */
  defaultValue?: any;

  /**
   * matTextSuffix
   */
  suffix?: string;

  /**
   * mat-select config
   */
  selectConfig?: FormSelectConfig;

  /**
   * mat-datepicker config
   */
  datePickerConfig?: FormDateConfig;

  /**
   * ng-select config
   */
  ngSelectConfig?: () => FormNgSelectConfig<any>;

  /**
   * listen when field value changed, to update validators or show/hide some section
   * @param {FormGroup} formGroup
   * @param {any} value new input value after changed
   */
  onChange?: (formGroup: FormGroup, value: any) => void;

  /**
   * condition to show/hide the field
   * @example
   * ```
   * visible: () => someCondition == true,
   * ```
   *
   * @returns {boolean}
   */
  visible?: () => boolean;

  /**
   * condition to enabled/disable the field
   * @example
   * ```
   * enabled: () => someCondition == true,
   * ```
   *
   * @returns {boolean}
   */
  enabled?: () => boolean;

  /**
   * file-picker config
   */
  fileConfig?: FormFileConfig;
}

/**
 * file picker config
 */
export interface FormFileConfig {
  /**
   * accepted mimeType
   */
  mimeType?: string;
}

/**
 * mat-form-field matInput type
 */
export enum FormInputType {
  file = 'file',
  text = 'text',
  email = 'email',
  password = 'password',
  number = 'number',
  date = 'date',
  select = 'select',
  multiSelect = 'multiSelect',
  checkbox = 'checkbox',
  toggle = 'toggle',
  ngSelect = 'ngSelect',
}

/**
 * mat-select config
 */
export interface FormSelectConfig {
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

  /**
   * mat-select options
   */
  options?: any[];

  /**
   * mat-select options
   */
  selectOption?: FormSelectOption;

  /**
   * show progressBar as suffix while get options from server
   */
  loading?: boolean;
}

/**
 * mat-select option config
 */
export interface FormSelectOption {
  /**
   * value of selected option
   * @example
   * ```
   * value: (e: Entity) => e.id,
   * ```
   * or:
   * @example
   * ```
   * value: (item: string) => item,
   * ```
   */
  value: ((x: any) => any),

  /**
   * displayed label of each option
   * @example
   * ```
   * label: (e: Entity) => e.name,
   * ```
   */
  label: ((x: any) => string),

  /**
   * translate `label` from `i18n/language.json`
   */
  i18n?: boolean;
}

/**
 * form static data object
 */
export interface FormStaticData {
  key: string;
  value?: any;
}

/**
 * mat-datepicker config
 */
export interface FormDateConfig {
  minDate?: Date;
  maxDate?: Date;
}

export interface FormNgSelectConfig<T> {

  /**
   * @param {string} endPoint filter api
   */
  endPoint: string;

  /**
   * @param {boolean} multiple select multiple options
   */
  multiple: boolean;

  /**
   * @param {string} bindLabel the key of object which will displayed in option
   */
  bindLabel: string;

  /**
   * @param {string} bindValue the key of object which will get value from it
   */
  bindValue: string;

  /**
   * @param {string} placeholder input placeholder
   */
  placeholder: string;

  /**
   * enable/disable input
   */
  enabled?: () => boolean;

  /**
   * create new instance from fetched data (use when `T` is class instead of interface)
   * @example
   * ```
   * factory: (item: any) => new Entity(item),
   * ```
   * @param item data which will displayed in each table row
   * @returns {T} new instance
   */
  factory?: (item: any) => T;



  /**
   * mapping response to initilize ng-select options
   * @example
   * ```
   * mappingResponse: (response: any) => response.list.my_objects,
   * ```
   * @param res data which will displayed in each table row
   * @returns {T} new instance
   */
  mappingResponse?: (res: any) => T[];

  /**
   * initialize ng-select with selected items by default (edit entity mode).
   * if you filter suggestions from server, the fetched list maybe doesn't contain the selected items,
   * in this case you will see the ng-select input is empty, becuase ng-select cannot find the selected-items from the current suggestions.
   * 
   * @returns {any[] | undefined}
   */
  initialItems?: () => any[];

  /**
   * send data with search query
   */
  queryParams?: string;

  /**
   * re-fetch data
   */
  refresh?: EventEmitter<any>;

  /**
   * search locally, pass `true` if the server fetch all data once and you want to filter input-query from the fetched list
   */
  searchLocally?: boolean
}

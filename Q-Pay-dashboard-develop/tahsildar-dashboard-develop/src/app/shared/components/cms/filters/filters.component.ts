import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatExpansionModule } from '@angular/material/expansion';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatIconModule } from '@angular/material/icon';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';
import { FilterSchema, FilterStrategies, FilterInputType, FilterSelectOption, FilterInterface } from 'src/app/shared/components/cms/filters/config/filter.iterface';
import { SharedModule } from '../../../modules/shared.module';
import { TranslationService } from '../../../services/translation.service';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSlideToggleModule } from '@angular/material/slide-toggle';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatMomentDateModule, MomentDateAdapter } from '@angular/material-moment-adapter';
import { DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE } from '@angular/material/core';
import { MY_DATE_FORMAT } from '../../forms/generic-form-builder/generic-form-builder.component';
import * as moment from 'moment';
import { GenericNgSelectComponent } from '../../forms/generic-ng-select/generic-ng-select.component';
import { CmsService } from '../services/cms.service';
import { finalize, Observable } from 'rxjs';

@Component({
  selector: 'app-filters',
  templateUrl: './filters.component.html',
  styleUrls: ['./filters.component.scss'],
  standalone: true,
  imports: [
    SharedModule,
    MatIconModule,
    MatInputModule,
    MatSelectModule,
    MatButtonModule,
    MatFormFieldModule,
    MatExpansionModule,
    MatDatepickerModule,
    MatMomentDateModule,
    MatSlideToggleModule,
    GenericNgSelectComponent,
    MatProgressSpinnerModule,
  ],
  providers: [
    MomentDateAdapter,
    { provide: MAT_DATE_FORMATS, useValue: MY_DATE_FORMAT },
    { provide: MAT_DATE_LOCALE, useValue: 'en-GB' },
    MatDatepickerModule,
  ]
})
export class FiltersComponent<T> {
  /**
   * @param {FilterSchema} filterSchema filter configuration
   */
  filterSchema!: FilterSchema;

  /**
   * @param numberStrategies list of options which used in `number` filter ['greater', 'equal', 'less']
   */
  public numberStrategies = [
    { value: FilterStrategies.gt, label: "greater" },
    { value: FilterStrategies.eq, label: "equal" },
    { value: FilterStrategies.lt, label: "less" },
  ];

  /**
   * @param {FilterInputType} inputType enum of filter input types
   */
  public inputType = FilterInputType;

  /**
   * @param {FilterSelectOption} defaultOption mat-select default option
   */
  public defaultOption: FilterSelectOption = new FilterSelectOption({ value: 'all', label: 'all' });

  /**
   * @param query general search query
   */
  public query: string = "";

  public panelOpenState = false;

  constructor(
    private cmsService: CmsService<T>,
    public translateService: TranslationService,
  ) {
    this.filterSchema = cmsService.filterSchema!;
  }

  /**
   * emit the inputs values
   */
  public applyFilters(): void {
    const inputs = {
      search: this.query,
    };

    this.filterSchema.inputs.forEach(input => {
      if (input.value != undefined && input.value != "all") {
        if (input.value instanceof Date || input.inputType == FilterInputType.date) {
          inputs[`${input.key}`] = moment(input.value).format('YYYY-MM-DD');
        } else {
          inputs[`${input.key}`] = input.value;
        }

        if (input.strategy) inputs[`${input.key}_strategy`] = input.strategy;
      }
    });

    this.cmsService.onFilterApplied(inputs);
  }

  /**
   * clear all filter inputs
   */
  public clearFilters() {
    this.query = "";
    this.filterSchema.inputs.forEach(input => input.value = undefined);
    this.cmsService.onFilterApplied({});
  }
}

import { Component, OnInit } from '@angular/core';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { MatCardModule } from '@angular/material/card';
import { StatisticsService } from '../services/statistics.service';
import { Statistics } from 'src/app/models/data/statistics.model';
import { finalize } from 'rxjs';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatDatepicker, MatDatepickerModule } from '@angular/material/datepicker';
import { MatNativeDateModule } from '@angular/material/core';
import { MatMomentDateModule, MomentDateAdapter } from '@angular/material-moment-adapter';
import { MatInputModule } from '@angular/material/input';
import * as moment from 'moment';
import { MatButtonModule } from '@angular/material/button';
import {LegendPosition, NgxChartsModule} from "@swimlane/ngx-charts";
import {MatListModule} from "@angular/material/list";
import {FilterInputType} from "../../../../../shared/components/cms/filters/config/filter.iterface";
import {
  GenericNgSelectComponent
} from "../../../../../shared/components/forms/generic-ng-select/generic-ng-select.component";
import {ngSelectMerchantConfig} from "../../../../../models/data/merchant.model";
import {TranslatePipe} from "@ngx-translate/core";
import { DateAdapter, MAT_DATE_FORMATS } from '@angular/material/core';
import { MY_DATE_FORMAT } from '../../../configuration/date-format';

@Component({
  selector: 'app-statistics-view',
  standalone: true,
  templateUrl: './statistics-view.component.html',
  styleUrls: ['./statistics-view.component.scss'],
  imports: [
    SharedModule,
    MatCardModule,
    MatInputModule,
    MatButtonModule,
    MatFormFieldModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatMomentDateModule,
    MatProgressSpinnerModule,
    NgxChartsModule,
    MatListModule,
    GenericNgSelectComponent
  ],
  providers: [
    MomentDateAdapter,
    StatisticsService,
    MatDatepickerModule,
    NgxChartsModule,
    TranslatePipe,
    { provide: MAT_DATE_FORMATS, useValue: MY_DATE_FORMAT }
  ]
})
export class StatisticsViewComponent implements OnInit {
  public statistics: { key: any, value: any , currency ?:boolean }[] = [];
  public bieChartsData: any[] = [];
  public countLineCharts: {name: string, value :number}[] = [];
  public sumLineCharts: {name: string, value :number}[] = [];
  public loading: boolean = false;
  public loadingChart: boolean = false;
  public date?: string =  moment().startOf('month').toISOString();
  public fromDate?: string =  moment().startOf('month').toISOString();
  public toDate?: string = moment().endOf('month').toISOString();
  private now = new Date();
  public start: string = new Date(this.now.getFullYear(),this.now.getMonth(),1).toISOString();
  public end: string = new Date(this.now.getFullYear(),this.now.getMonth()+ 1,0).toISOString();
  public selectedMerchant?:any;
  public minDate: Date=new Date(2024, 0, 1);


  // Additional configuration options can be set here
  view: [number, number] = [700, 400];
  colorScheme = {
    domain: ['#5AA454', '#A10A28', '#C7B42C']
  };

  colorPieChartIndex = 0;
  legendPosition: LegendPosition = LegendPosition.Below;
  legendTitle = "";
  colorBarChartIndex = 4;
  customColorsPieChart = () => {
    const colors = ["#5a00e1", "#9680ff"];
    const index = this.colorPieChartIndex;
    this.colorPieChartIndex++;
    if (this.colorPieChartIndex == 2) this.colorPieChartIndex = 0;
    return colors[index];
  }

  gradient = false;
  showXAxis = true;
  showYAxis = true;
  showLegend = true;
  showXAxisLabel = true;
  xAxisLabel = '';
  showYAxisLabel = true;
  yAxisLabel = 'Population';
  constructor(
    private statisticsService: StatisticsService,
    private errorService: ErrorService,
    private translatePipe: TranslatePipe
  ) { 
  }

  ngOnInit(): void {
    this.getStatistics();
    this.getChartStatistics();
  }

  public monthSelected(normalizedMonthAndYear: moment.Moment, datepicker: MatDatepicker<moment.Moment>) {
    // this.date = moment(event).format('YYYY/MM/DD');
    // const date = new Date();
    // date.setMonth(normalizedMonthAndYear.month());
    // date.setFullYear(normalizedMonthAndYear.year());
    // this.date = date.toISOString();
    // datepicker.close();
    // this.getStatistics();
  }

  /**
   * fetch data without date
   * @param event
   */
  public clearDate(): void {
    this.fromDate =  moment().startOf('month').toISOString();
    this.toDate = moment().endOf('month').toISOString();
    this.getStatistics();
  }

  /**
   * fetch statistics from server
   */
  public getStatistics(): void {
    this.loading = true;
    const query = {};
    if(!this.fromDate)
      this.fromDate=moment().startOf('month').toISOString();
    if(!this.toDate)
      this.toDate=moment().endOf('month').toISOString();
    query["from_date"] = moment(this.fromDate).format("YYYY-MM-DD");
    query["to_date"] = moment(this.toDate).format("YYYY-MM-DD");
    this.statisticsService.get<Statistics>('', query)
      .pipe(finalize(() => this.loading = false))
      .subscribe({
        next: (data) => {
          this.statistics = [
            {
              key: 'total_merchants',
              value: data.merchants?.total_merchants ?? ''
            },
            {
              key: 'total_active_merchants',
              value: data.merchants?.total_active_merchants ?? ''
            },
            {
              key: 'total_transactions',
              value: data.transactions?.total_transactions ?? ''
            },
            {
              key: 'unsuccessful_transactions',
              value: data.transactions?.unsuccessful_transactions ?? ''
            },
            {
              key: 'requested_transactions_value',
              value: data.transactions?.pending_value ?? '',
              currency: true
            },
            {
              key: 'paid_transactions_value',
              value: data.transactions?.paid_value ?? '',
              currency : true
            },
          ];

          this.bieChartsData = [
            {
              name: "merchants",
              data: [
                {
                  name: this.translatePipe.transform('total_merchants'),
                  value: data.merchants?.total_merchants ?? ''
                },
                {
                  name: this.translatePipe.transform('total_active_merchants'),
                  value: data.merchants?.total_active_merchants ?? ''
                }
              ]
            },
            {
              name: "transactions",
              data: [
                {
                  name: this.translatePipe.transform('total_transactions'),
                  value: data.transactions?.total_transactions ?? ''
                },
                {
                  name: this.translatePipe.transform('unsuccessful_transactions'),
                  value: data.transactions?.unsuccessful_transactions ?? ''
                },
              ]
            }, {
              name: "transactions_amount",
              data: [
                {
                  name: this.translatePipe.transform('requested_transactions_value'),
                  value: data.transactions?.pending_value ?? '',
                },
                {
                  name: this.translatePipe.transform('paid_transactions_value'),
                  value: data.transactions?.paid_value ?? '',
                }
              ]
            }
          ]
        },
        error: (error) => this.errorService.showMessage(error?.message || error),
      });
  }
  public getChartStatistics(): void {
    this.loadingChart = true;
    const query = {};
    query["start"] = moment(this.start).format("YYYY-MM-DD");
    query["end"] = moment(this.end).format("YYYY-MM-DD");
    if (this.selectedMerchant)
      query["user_id"] = this.selectedMerchant;
    this.statisticsService.get<any>('line-chart', query)
      .pipe(finalize(() => this.loadingChart = false))
      .subscribe({
        next: (data) => {
          this.countLineCharts = data.countData
          this.sumLineCharts = data.totalData
        },
        error: (error) => this.errorService.showMessage(error?.message || error),
      });
  }

  protected readonly FilterInputType = FilterInputType;
  protected readonly ngSelectMerchantConfig = ngSelectMerchantConfig;
}

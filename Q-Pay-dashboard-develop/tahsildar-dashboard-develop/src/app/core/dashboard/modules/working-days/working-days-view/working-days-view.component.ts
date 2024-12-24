import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { WorkingDaysService } from '../services/working-days.service';
import { TranslatePipe } from "@ngx-translate/core";
import { DateAdapter, MAT_DATE_FORMATS } from '@angular/material/core';
import { MY_DATE_FORMAT } from '../../../configuration/date-format';
import { ErrorService } from "../../../../../shared/services/http/error.service";
import dayGridPlugin from '@fullcalendar/daygrid'
import { CalendarOptions } from "@fullcalendar/core";
import { FullCalendarComponent, FullCalendarModule } from "@fullcalendar/angular";
import interactionPlugin from '@fullcalendar/interaction';
import { WorkingDayHoliday } from "../../../../../models/data/working-day-holiday.model";
import { MatDialog } from '@angular/material/dialog';
import { AddEventDialogComponent } from "../add-event-dialog/add-event-dialog.component";
import { MatProgressSpinnerModule } from "@angular/material/progress-spinner";
import { MatProgressBarModule } from "@angular/material/progress-bar";
import { AuthService } from 'src/app/shared/services/auth.service';

@Component({
  selector: 'app-working-days-view',
  standalone: true,
  encapsulation: ViewEncapsulation.None,
  templateUrl: './working-days-view.component.html',
  styleUrls: ['./working-days-view.component.scss'],
  imports: [
    SharedModule,
    MatProgressBarModule,
    FullCalendarModule
  ],
  providers: [
    WorkingDaysService,
    TranslatePipe,
    { provide: MAT_DATE_FORMATS, useValue: MY_DATE_FORMAT }
  ]
})
export class WorkingDaysViewComponent implements OnInit {

  showAddEvent = false;
  permissionCategory = "Working days";
  public loading: boolean = false;
  calendarOptions: CalendarOptions = {
    initialView: 'dayGridMonth',
    fixedWeekCount: false,
    height: 800,
    plugins: [dayGridPlugin, interactionPlugin],
    dateClick: this.handleDateClick.bind(this),
    datesSet: this.changeMonthView.bind(this),
  };

  events: Array<{ title: string, date: string }> = [];

  constructor(
    private workingDaysService: WorkingDaysService,
    private errorService: ErrorService,
    private translatePipe: TranslatePipe,
    private authService: AuthService,
    public dialog: MatDialog
  ) { }
  ngOnInit(): void {
    this.showAddEvent = this.authService.checkPermission(this.permissionCategory, "Add event");
  }



  // event is the first day on the calendar
  changeMonthView(event: any) {
    // if the first day is not the first day in the month add 1 to the month
    if (event.start.getDay() != 1) {
      event.start = new Date(event.start.setMonth(event.start.getMonth() + 1));

    }
    const currentMonth = event.start.getMonth() + 1;
    const currentYear = event.start.getFullYear();
    this.getEventsInAMonth(currentMonth, currentYear);
  }

  getEventsInAMonth(month: number, year: number) {
    this.loading = true;
    this.workingDaysService.get<Array<WorkingDayHoliday>>('', {
      "month": month,
      "year": year, "isPaginate": false
    }).pipe().subscribe(events => {
      this.loading = false
      this.events = events.map(event => {
        return { title: event.name, date: event.date };
      });
      this.calendarOptions = {
        ...this.calendarOptions,
        events: [...this.events]
      };
    });
  }



  addEvent(name: string, date: string) {

    this.loading = true;

    this.workingDaysService.post<WorkingDayHoliday>('', { name: name, date: date }).pipe().subscribe(
      event => {
        this.loading = false;
        this.events.push({
          title: event.name,
          date: event.date,
        });
        this.calendarOptions = {
          ...this.calendarOptions,
          events: [...this.events]
        };
      }
    )


  }

  handleDateClick(event: any) {
    //
    if (!this.showAddEvent)
      return;
    const date = new Date(event.dateStr);
    const day = date.getDay();
    if (day === 5 || day === 6) {
      return;
    }
    const dialogRef = this.dialog.open(AddEventDialogComponent, {
      width: '400px',
      data: { date: "qeqweq" }
    });

    dialogRef.afterClosed().subscribe((result: string | null) => {

      if (result) {
        this.addEvent(result, date.toISOString().split('T')[0]);
        console.log('Event added:', result);
      }
    });
  }

}

import { ChangeDetectorRef, Component, EventEmitter, Input, OnInit, Output, TemplateRef } from '@angular/core';
import { Location } from '@angular/common';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { ActivatedRoute } from '@angular/router';
import { finalize } from 'rxjs';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { HttpService } from 'src/app/shared/services/http/http.service';

@Component({
  selector: 'app-cms-view',
  standalone: true,
  templateUrl: './cms-view.component.html',
  styleUrls: ['./cms-view.component.scss'],
  imports: [
    SharedModule,
    MatProgressSpinnerModule,
  ],
  providers: [
    HttpService,
  ],
})
export class CmsViewComponent<T> implements OnInit {

  /**
   * @param {string} endPoint api which called to fetch data form server
   */
  @Input() endPoint?: string;

  /**
   * @param {T} item inject item data instead of fetch it in this component
   */
  @Input() item?: T;

  /**
   * @param {TemplateRef} template your model layout which will be rendered inside `cms-view.component.html`
   */
  @Input() template!: TemplateRef<any>;

  /**
   * @param {EventEmitter<T>} onDataFetched event emitter to notify parent that new data is fetched from server
   * it used to modify the list like pipe date or edit some element in the list
   */
  @Output() onDataFetched: EventEmitter<T> = new EventEmitter();

  /**
   * @param {boolean} loading to disable button
   */
  @Input() loading: boolean = false;

  private id?: string;

  constructor(
    private errorService: ErrorService,
    private httpService: HttpService,
    private cdr: ChangeDetectorRef,
    readonly route: ActivatedRoute,
    private location: Location,
  ) {
    route.params.subscribe(data => { this.id = data["id"] });
  }

  ngOnInit(): void {
    if (this.id) {
      this.getItemById(`${this.endPoint}/${this.id}`);
    } else {
      this.location.back();
    }
  }

  ngAfterViewInit(): void {
    this.cdr.detectChanges();
  }

  /**
   * get item details from server
   * @param {string} endPoint api which called to fetch data form server
   */
  public getItemById(endPoint?: string): void {
    this.loading = true;
    this.httpService.get<T>(endPoint)
      .pipe(finalize(() => this.loading = false))
      .subscribe({
        next: (data) => {
          this.item = data;
          this.onDataFetched.emit(this.item);
        },
        error: (error) => {
          this.errorService.showMessage(error?.message || error);
          this.location.back();
        }
      });
  }
}

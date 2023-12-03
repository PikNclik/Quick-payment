import { Injectable } from '@angular/core';
import { Observable, Observer } from 'rxjs';
import { MatDialog } from '@angular/material/dialog';
import { CmsUpdateComponent } from './cms-update.component';
import { FormConfig } from 'src/app/shared/components/forms/config/forms.config';
import { environment } from 'src/environments/environment';

@Injectable()
export class CmsUpdateService<T>  {
  constructor(public dialog: MatDialog) { }

  /**
   * open edit-dialog
   * @param {string} item inject item inside generic-update-component
   * @param {FormConfig<T>} formConfig form config
   * @returns {Observable<boolean>}
   */
  public openDialog(endPoint: string, formConfig: (item?: T) => FormConfig<T>): Observable<boolean> {
    return new Observable((observer: Observer<boolean>) => {
      const dialogRef = this.dialog.open(CmsUpdateComponent<T>, {
        width: environment.dialogWidth,
        maxHeight: environment.dialogHeight,
      });
      const instance = dialogRef.componentInstance;

      // fetch item data
      instance.formConfig = formConfig();
      instance.fetchingData = true;
      instance.form.getItemById(endPoint).then((data?: T) => {
        if (!data) {
          dialogRef.close();
          return;
        }
        instance.form.id = data["_id"] || data["id"];
        instance.form.item = data;
        instance.formConfig = formConfig(data);
        instance.formConfig.submitButton = false;
        instance.fetchingData = false;
        instance.cdr.detectChanges();
      });

      // submit form data to server
      instance.onSubmit = () => {
        instance.loading = true;
        instance.form.formBuilder?.submit();
      }

      // callback when request finished
      instance.form.callback = (success: boolean) => {
        if (success) dialogRef.close(true);
        else instance.loading = false;
      }

      dialogRef.afterClosed().subscribe((result: any) => {
        if (result) observer.next(result);
        observer.complete();
      });
    });
  }
}

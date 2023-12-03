import { Injectable } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { Observable, Observer } from 'rxjs';
import { FormConfig } from 'src/app/shared/components/forms/config/forms.config';
import { environment } from 'src/environments/environment';
import { CmsCreateComponent } from './cms-create.component';

@Injectable()
export class CmsCreateService<T> {
  constructor(public dialog: MatDialog) { }

  /**
   * open edit-dialog
   * @param {FormConfig<T>} formConfig form config
   * @returns {Observable<boolean>}
   */
  public openDialog(formConfig: FormConfig<T>): Observable<boolean> {
    return new Observable((observer: Observer<boolean>) => {
      const dialogRef = this.dialog.open(CmsCreateComponent<T>, {
        width: environment.dialogWidth,
        maxHeight: environment.dialogHeight,
      });
      const instance = dialogRef.componentInstance;
      formConfig.submitButton = false;
      instance.formConfig = formConfig;

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

      // return value to dialog caller
      dialogRef.afterClosed().subscribe((result: any) => {
        if (result) observer.next(result);
        observer.complete();
      });
    });
  }
}

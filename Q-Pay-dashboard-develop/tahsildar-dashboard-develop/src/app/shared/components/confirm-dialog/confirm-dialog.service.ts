import { Injectable } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { Observable, Observer } from 'rxjs';
import { ConfirmDialogComponent } from './confirm-dialog.component';

@Injectable()
export class ConfirmDialogService {
    constructor(public dialog: MatDialog) { }

    public open(title: string, content: string): Observable<boolean> {
        return new Observable((observer: Observer<boolean>) => {
            const dialogRef = this.dialog.open(ConfirmDialogComponent, { disableClose: false, width: '450px' });
            dialogRef.componentInstance.title = title;
            dialogRef.componentInstance.content = content;
            dialogRef.afterClosed().subscribe((confirmation: boolean) => {
                if (confirmation) observer.next(confirmation);
                observer.complete();
            });
        });
    }
}

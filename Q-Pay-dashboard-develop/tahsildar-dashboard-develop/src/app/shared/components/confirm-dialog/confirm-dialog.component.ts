import { Component } from '@angular/core';
import { MatDialogModule, MatDialogRef } from '@angular/material/dialog';
import { SharedModule } from '../../modules/shared.module';
import { MatButtonModule } from '@angular/material/button';

@Component({
  selector: 'app-confirm-dialog',
  templateUrl: './confirm-dialog.component.html',
  styleUrls: ['./confirm-dialog.component.scss'],
  standalone: true,
  imports: [
    SharedModule,
    MatDialogModule,
    MatButtonModule,
  ]
})
export class ConfirmDialogComponent {
  public title: string = "";
  public content: string = "";

  constructor(public _dialogRef: MatDialogRef<ConfirmDialogComponent>) { }
}

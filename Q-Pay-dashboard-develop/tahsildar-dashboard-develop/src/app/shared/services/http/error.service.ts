import { Injectable } from "@angular/core";
import { MatSnackBar } from "@angular/material/snack-bar";

@Injectable({ providedIn: 'root' })
export class ErrorService {
  constructor(private snackBar: MatSnackBar) { }

  /**
   * show an error message to user
   * @param {any} message error message
   */
  public showMessage(message: any) {
    this.snackBar.open(message);
  }
}

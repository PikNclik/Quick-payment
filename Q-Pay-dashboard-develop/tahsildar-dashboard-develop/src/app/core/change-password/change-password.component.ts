import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatButtonModule } from '@angular/material/button';
import { MatInputModule } from '@angular/material/input';
import { MatCardModule } from '@angular/material/card';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { MatIconModule } from '@angular/material/icon';
import { AbstractControl, FormBuilder, FormGroup, ValidationErrors, Validators } from '@angular/forms';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { finalize } from 'rxjs';
import { AuthService } from 'src/app/shared/services/auth.service';
import { MatDialogModule, MatDialogRef } from '@angular/material/dialog';

@Component({
  selector: 'app-change-password',
  standalone: true,
  imports: [
    CommonModule,
    MatFormFieldModule,
    MatButtonModule,
    MatInputModule,
    MatCardModule,
    MatDialogModule,
    SharedModule,
    MatIconModule
  ],
  templateUrl: './change-password.component.html',
  styleUrls: ['./change-password.component.scss']
})
export class ChangePasswordComponent {

  loading=false;
  hideOldPassword = true;
  hideNewPassword = true;
  hidePasswordConfirmatoin = true;
  public formGroup!: FormGroup;


  constructor(
    private errorService: ErrorService,
    private formBuilder: FormBuilder,
    private authService: AuthService,
    protected dialogRef: MatDialogRef<ChangePasswordComponent>,
  ) { }

  ngOnInit(): void {
    this.initializeForm();
  }

  private initializeForm(): void {
    this.formGroup = this.formBuilder.group({
      old_password: ['', Validators.required],
      new_password: [
        '',
        [
          Validators.required,
          Validators.minLength(8),
          Validators.maxLength(30),
          this.passwordPatternValidator()
        ],
      ],
      confirm_password: ['', [Validators.required,this.passwordMatchValidator()]],
    });
    this.formGroup.get('new_password')?.valueChanges.subscribe(() => {
      this.formGroup.get('confirm_password')?.updateValueAndValidity();
    });
  }

  passwordPatternValidator(): (control: AbstractControl) => ValidationErrors | null {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/;
    return (control: AbstractControl): ValidationErrors | null => {
      if (control.value && !regex.test(control.value)) {
        return { passwordPattern: true };
      }
      return null;
    };
  }


  passwordMatchValidator(): (control: AbstractControl) => ValidationErrors | null {
    return (control: AbstractControl): ValidationErrors | null => {
      if (this.formGroup && control.value !== this.formGroup.get('new_password')?.value) {
        return { passwordMismatch: true };
      }
      return null;
    };
  }

  togglePasswordVisibility(index: number): void {
    if (index == 1)
      this.hideOldPassword = !this.hideOldPassword;
    else if (index == 2)
      this.hideNewPassword = !this.hideNewPassword
    else
      this.hidePasswordConfirmatoin = !this.hidePasswordConfirmatoin
  }

  public submit () {
    this.loading = true;
    this.authService.post('change-password',this.formGroup.value)
      .pipe(finalize(() => this.loading = false))
      .subscribe({
        next: () => {
          this.errorService.showMessage("Password Changes Successfully");
          this.dialogRef.close();
        },
        error: (error) => {
          this.errorService.showMessage(error?.message || error);
        },
      });
  }
}
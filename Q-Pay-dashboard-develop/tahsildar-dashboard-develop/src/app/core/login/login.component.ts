import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { Router } from '@angular/router';
import { finalize } from 'rxjs';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { AuthService } from 'src/app/shared/services/auth.service';
import { ErrorService } from 'src/app/shared/services/http/error.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
  standalone: true,
  imports: [
    MatProgressBarModule,
    MatFormFieldModule,
    MatButtonModule,
    MatInputModule,
    MatCardModule,
    SharedModule,
  ],
})
export class LoginComponent implements OnInit {
  public formGroup!: FormGroup;
  public loading: boolean = false;

  constructor(
    private errorService: ErrorService,
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private router: Router,
  ) { }

  ngOnInit(): void {
    this.isLoggedIn();
    this.initializeForm();
  }

  /**
   * check if user loggedIn
   */
  private isLoggedIn(): void {
    const isLoggedIn = this.authService.isLoggedIn();
    if (isLoggedIn) this.navigate();
  }

  /**
   * initailize login form
   */
  private initializeForm(): void {
    this.formGroup = this.formBuilder.group({
      username: ['', Validators.required],
      password: ['', Validators.required],
    });
  }

  /**
   * send credentials to server
   */
  public login(): void {
    this.loading = true;
    this.authService.login(this.formGroup.value)
      .pipe(finalize(() => this.loading = false))
      .subscribe({
        next: () => this.navigate(),
        error: (error) => this.errorService.showMessage(error?.message || error),
      });
  }

  /**
   * navigate to home
   */
  private navigate(): void {
    this.router.navigate(['dashboard'], { replaceUrl: true });
  }
}

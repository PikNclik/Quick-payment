import { Component } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatToolbarModule } from '@angular/material/toolbar';
import { NavigationEnd, Router } from '@angular/router';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { DrawerService } from 'src/app/shared/services/drawer.service';
import { AuthService } from 'src/app/shared/services/auth.service';
import { ConfirmDialogService } from '../confirm-dialog/confirm-dialog.service';
import { Title } from '@angular/platform-browser';
import { environment } from 'src/environments/environment';
import { MatMenuModule } from '@angular/material/menu';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatDialog } from '@angular/material/dialog';
import { ChangePasswordComponent } from 'src/app/core/change-password/change-password.component';
import { MatBadgeModule } from '@angular/material/badge';
import { filter } from 'rxjs';

@Component({
  selector: 'app-toolbar',
  standalone: true,
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.scss'],
  imports: [
    MatToolbarModule,
    MatButtonModule,
    MatIconModule,
    MatBadgeModule,
    SharedModule,
    MatMenuModule
  ],
  providers: [
    ConfirmDialogService,
  ]
})
export class ToolbarComponent {

  newMerchantsCount = null;
  showCount=false
  constructor(
    private confirmDialogService: ConfirmDialogService,
    public drawerService: DrawerService,
    private authService: AuthService,
    private titleService: Title,
    public router: Router,
    public passwordDialog: MatDialog
  ) { }
  ngOnInit(): void {
    this.getNewMerchantsCount();
    this.router.events
    .pipe(filter((event) => event instanceof NavigationEnd))
    .subscribe(() => {
      this.getNewMerchantsCount();
    });
    
  }

  public toggle(): void {
    this.drawerService.showDrawer$.next(true);
  }

  public logOut(): void {
    this.confirmDialogService.open('logout', 'are_you_sure').subscribe(result => {
      if (result) {
        this.authService.removeUser();
        this.router.navigateByUrl('/login');
      }
    });
  }

  public getTitle(): string {
    return this.titleService.getTitle().replace(`${environment.titlePrefix} | `, "");
  }

  public getNewMerchantsCount() {
    this.newMerchantsCount = null;
    this.showCount = this.router.url == '/dashboard/merchants';  
    if(!this.showCount) return;
    this.authService.get('new-merchants-count')
      .pipe()
      .subscribe({
        next: (data: any) => {
          this.newMerchantsCount = data.count;

        },
        error: (error) => {
        },
      });
  }

  public changePassword() {
    const dialogRef = this.passwordDialog.open(ChangePasswordComponent, {
      maxWidth: '60vw',
      width: '40vw'
    });

    dialogRef.afterClosed().subscribe((result: boolean) => {
      if (!result) return;


    });
  }
}

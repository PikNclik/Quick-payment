import { Component } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatToolbarModule } from '@angular/material/toolbar';
import { Router } from '@angular/router';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { DrawerService } from 'src/app/shared/services/drawer.service';
import { AuthService } from 'src/app/shared/services/auth.service';
import { ConfirmDialogService } from '../confirm-dialog/confirm-dialog.service';
import { Title } from '@angular/platform-browser';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-toolbar',
  standalone: true,
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.scss'],
  imports: [
    MatToolbarModule,
    MatButtonModule,
    MatIconModule,
    SharedModule,
  ],
  providers: [
    ConfirmDialogService,
  ]
})
export class ToolbarComponent {
  constructor(
    private confirmDialogService: ConfirmDialogService,
    public drawerService: DrawerService,
    private authService: AuthService,
    private titleService: Title,
    public router: Router,
  ) { }

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
}

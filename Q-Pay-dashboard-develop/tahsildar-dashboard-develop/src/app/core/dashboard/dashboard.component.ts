import { Component, OnInit, ViewChild } from '@angular/core';
import { BreakpointObserver, Breakpoints } from '@angular/cdk/layout';
import { MatDrawer, MatSidenavModule } from '@angular/material/sidenav';
import { ToolbarComponent } from 'src/app/shared/components/toolbar/toolbar.component';
import { SharedModule } from 'src/app/shared/modules/shared.module';
import { TranslationService } from 'src/app/shared/services/translation.service';
import { Observable, map, shareReplay } from 'rxjs';
import { MatIconModule } from '@angular/material/icon';
import { MatListModule } from '@angular/material/list';
import { dashboardNavLinks } from './configuration/dashboard.navigation';
import { User } from 'src/app/models/data/user.model';
import { AuthService } from 'src/app/shared/services/auth.service';
import { DrawerService } from 'src/app/shared/services/drawer.service';
import { MatDialogModule } from '@angular/material/dialog';

@Component({
  selector: 'app-dashboard',
  standalone: true,
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss'],
  imports: [
    SharedModule,
    MatIconModule,
    MatListModule,
    MatDialogModule,
    MatSidenavModule,
    ToolbarComponent,
  ]
})
export class DashboardComponent implements OnInit {
  @ViewChild("drawer", { static: false }) drawer?: MatDrawer;
  public user?: User;
  public navItems = dashboardNavLinks;
  public isHandset$!: Observable<boolean>;

  constructor(
    public readonly translationService: TranslationService,
    private breakpointObserver: BreakpointObserver,
    public drawerService: DrawerService,
    private authService: AuthService,
  ) { }

  ngOnInit(): void {
    this.user = this.authService.getUser();
    this.isHandset$ = this.breakpointObserver
      .observe(Breakpoints.Handset)
      .pipe(
        map((result) => result.matches),
        shareReplay()
      );
    this.subscribeDrawerToggle();
  }

  /**
   * Display/Hide drawer depending on action from toolbar
   */
  private subscribeDrawerToggle() {
    this.drawerService.showDrawer$.subscribe(() => {
      this.drawer?.toggle();
    });
  }
}

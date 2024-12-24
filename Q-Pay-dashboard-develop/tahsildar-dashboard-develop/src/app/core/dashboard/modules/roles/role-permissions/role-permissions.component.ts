import { ChangeDetectorRef, Component, Inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  MatDialogRef,
  MAT_DIALOG_DATA,
  MatDialogModule
} from '@angular/material/dialog';
import { ErrorService } from 'src/app/shared/services/http/error.service';
import { PermissionCategoryService } from '../services/permission-category.service';
import { PermissionService } from '../services/permission.service';
import { Permission } from 'src/app/models/data/permission.model';
import { PermissionCategory } from 'src/app/models/data/permission_category.model';
import { MatTabsModule } from '@angular/material/tabs';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { RoleService } from '../services/role.service';
import { Role } from 'src/app/models/data/role.model';
import { MatButtonModule } from '@angular/material/button';
import { AuthService } from 'src/app/shared/services/auth.service';


@Component({
  selector: 'app-role-permissions',
  standalone: true,
  imports: [
    CommonModule,
    MatTabsModule,
    MatDialogModule,
    MatProgressSpinnerModule,
    MatCheckboxModule,
    MatButtonModule
  ],
  providers: [
    PermissionCategoryService,
    PermissionService,
    RoleService
  ],
  templateUrl: './role-permissions.component.html',
  styleUrls: ['./role-permissions.component.scss']
})
export class RolePermissionsComponent {

  categories: PermissionCategory[] = [];
  permissions: Permission[] = [];
  permissionsLoading = false;
  roleLoading = false;
  selectedPermissions: number[] = [];

  constructor(
    @Inject(MAT_DIALOG_DATA)
    public data: { roleId: number },
    private cdr: ChangeDetectorRef,
    protected dialogRef: MatDialogRef<RolePermissionsComponent>,
    private permissionCategoryService: PermissionCategoryService,
    private permissionService: PermissionService,
    private roleService: RoleService,
    private errorService: ErrorService,
    private authService: AuthService

  ) { }

  ngOnInit(): void {
    this.getRole();
    this.categories=this.authService.getPermissionCategories();
    this.getPermissions();

  }
  // getPermissionCategories() {
  //   this.categoriesLoading = true;
  //   this.permissionCategoryService.getPermissionCategories()
  //     .subscribe({
  //       next: (data) => {
  //         this.categories = data
  //         this.cdr.detectChanges();
  //         this.categoriesLoading = false;
  //       },
  //       error: (error) => {
  //         this.errorService.showMessage(error?.message || error)
  //         this.categoriesLoading = false;
  //       },
  //     });
  // }
  getPermissions() {
    this.permissionsLoading = true;
    this.permissionService.getPermissions()
      .subscribe({
        next: (data) => {
          this.permissions = data
          this.cdr.detectChanges();
          this.permissionsLoading = false;
        },
        error: (error) => {
          this.errorService.showMessage(error?.message || error)
          this.permissionsLoading = false;
        },
      });
  }
  getRole() {
    this.roleLoading = true;
    this.roleService.get<Role>("" + this.data.roleId)
      .subscribe({
        next: (data: Role) => {
          if (data && data.permissions) {
            data.permissions.forEach(permission => {
              this.selectedPermissions.push(permission.id??0)
            });
          }
          this.cdr.detectChanges();
          this.roleLoading = false;
        },
        error: (error) => {
          this.errorService.showMessage(error?.message || error)
          this.roleLoading = false;
        },
      });
  }

  public getPermissionByCategory(id: any) {
    return this.permissions.filter(a => a.category_id == id);
  }
  public save() {
    this.permissionsLoading = true;
    const payload = {
      'id': this.data.roleId,
      'permissions': this.selectedPermissions
    };
    this.roleService.post("permissions", payload)
      .subscribe({
        next: (data: any) => {
          this.permissionsLoading = false;
          this.dialogRef.close();
        },
        error: (error) => {
          this.errorService.showMessage(error?.message || error)
          this.permissionsLoading = false;
        },
      });
  }
  onPermissionChange(id: number, isChecked: boolean): void {
    if (isChecked) {
      this.selectedPermissions.push(id);
    } else {
      this.selectedPermissions = this.selectedPermissions.filter(permissionId => permissionId !== id);
    }
  }
}

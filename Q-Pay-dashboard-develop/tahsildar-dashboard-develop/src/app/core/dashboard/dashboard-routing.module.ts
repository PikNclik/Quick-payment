import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { DashboardComponent } from './dashboard.component';
import {Setting} from "../../models/data/setting.model";
import { RoleGuard } from 'src/app/shared/guards/role.guard';

const routes: Routes = [
  {
    path: '',
    loadComponent: () => DashboardComponent,
    children: [
      {
        path: '',
        redirectTo: 'statistics',
        pathMatch: 'full'
      },
      {
        path: 'merchants',
        loadChildren: () => import('../dashboard/modules/merchants/merchants.module').then(m => m.MerchantsModule),
        data: { title: 'merchants',permissionCategory: 'Merchants' },
        canActivate: [RoleGuard]
      },
      {
        path: 'admins',
        loadChildren: () => import('../dashboard/modules/admins/admins.module').then(m => m.AdminsModule),
        data: { title: 'admins',permissionCategory: 'Super Admin' },
        canActivate: [RoleGuard]
      },
      {
        path: 'roles',
        loadChildren: () => import('../dashboard/modules/roles/roles.module').then(m => m.RolesModule),
        data: { title: 'admins',permissionCategory: 'Super Admin' },
        canActivate: [RoleGuard]
      },
      {
        path: 'audit',
        loadChildren: () => import('../dashboard/modules/audit/audit.module').then(m => m.AuditModule),
        data: { title: 'audit',permissionCategory: 'Super Admin' },
        canActivate: [RoleGuard]
      },
      {
        path: 'banks',
        loadChildren: () => import('../dashboard/modules/banks/banks.module').then(m => m.BanksModule),
        data: { title: 'banks',permissionCategory: 'Banks Management' },
        canActivate: [RoleGuard]
      },
      {
        path: 'transactions',
        loadChildren: () => import('../dashboard/modules/transactions/transactions.module').then(m => m.TransactionsModule),
        data: { title: 'transactions',permissionCategory: 'Reports' },
        canActivate: [RoleGuard]
      },
      {
        path: 'statistics',
        loadChildren: () => import('../dashboard/modules/statistics/statistics.module').then(m => m.StatisticsModule),
        data: { title: 'statistics'}
      },
      // {
      //   path: 'system-bank',
      //   loadChildren: () => import('../dashboard/modules/system-bank-data/system-bank-data.module').then(m => m.SystemBankDataModule),
      //   data: { title: 'system_bank',role: 'Admin'  },
      //   canActivate: [RoleGuard]
      // },
      {
        path: 'terminal-bank',
        loadChildren: () => import('../dashboard/modules/terminal-bank/terminal-bank.module').then(m => m.TerminalBankModule),
        data: { title: 'terminal_bank',permissionCategory: 'Terminal accounts'  },
        canActivate: [RoleGuard]
      },
      {
        path: 'transaction-to-do',
        loadChildren: () => import('../dashboard/modules/transaction-to-do/transaction-to-do.module').then(m => m.TransactionToDoModule),
        data: { title: 'transaction_to_do',permissionCategory: 'Transaction to do'  },
        canActivate: [RoleGuard]
      },
      {
        path: 'customers',
        loadChildren: () => import('../dashboard/modules/customers/customers.module').then(m => m.CustomersModule),
        data: { title: 'customers',permissionCategory: 'Customers'  },
        canActivate: [RoleGuard]
      },
      {
        path: 'working-days',
        loadChildren: () => import('../dashboard/modules/working-days/working-days.module').then(m => m.WorkingDaysModule),
        data: { title: 'Working Days',permissionCategory: 'Working days'  },
        canActivate: [RoleGuard]
      },
      {
        path: 'settings',
        loadChildren: () => import('../dashboard/modules/settings/settings.module').then(m => m.SettingsModule),
        data: { title: 'settings',permissionCategory: 'Settings'  },
        canActivate: [RoleGuard]
      }
    ]
  },
  {
    path: '**',
    redirectTo: '',
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class DashboardRoutingModule { }

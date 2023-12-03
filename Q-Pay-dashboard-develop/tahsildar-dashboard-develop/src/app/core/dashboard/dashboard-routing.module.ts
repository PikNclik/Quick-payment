import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { DashboardComponent } from './dashboard.component';

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
        data: { title: 'merchants' },
      },
      {
        path: 'banks',
        loadChildren: () => import('../dashboard/modules/banks/banks.module').then(m => m.BanksModule),
        data: { title: 'banks' },
      },
      {
        path: 'transactions',
        loadChildren: () => import('../dashboard/modules/transactions/transactions.module').then(m => m.TransactionsModule),
        data: { title: 'transactions' },
      },
      {
        path: 'statistics',
        loadChildren: () => import('../dashboard/modules/statistics/statistics.module').then(m => m.StatisticsModule),
        data: { title: 'statistics' },
      },
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

import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: '',
    children: [
      {
        path: '',
        loadComponent: () => import('./system-bank-data-list/system-bank-data-list.component').then(e => e.SystemBankDataListComponent),
        data: { title: 'system_bank' }
      },
    ]
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class SystemBankDataRoutingModule { }

import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: '',
    children: [
      {
        path: '',
        loadComponent: () => import('./transaction-to-do-list/transaction-to-do-list.component').then(e => e.TransactionToDoListComponent),
        data: { title: 'settlement_files' }
      },
    ]
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TransactionToDoRoutingModule { }

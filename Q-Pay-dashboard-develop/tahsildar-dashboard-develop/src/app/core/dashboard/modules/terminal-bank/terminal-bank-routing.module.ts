import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: '',
    children: [
      {
        path: '',
        loadComponent: () => import('./terminal-bank-list/terminal-bank-list.component').then(e => e.TerminalBankListComponent),
        data: { title: 'terminal_bank' }
      },
    ]
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TerminalBankRoutingModule { }

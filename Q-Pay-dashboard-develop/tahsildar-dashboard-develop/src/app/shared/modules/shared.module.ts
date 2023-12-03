import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { TranslateModule } from '@ngx-translate/core';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { FlexLayoutModule } from '@angular/flex-layout';

@NgModule({
  imports: [
    FormsModule,
    CommonModule,
    RouterModule,
    TranslateModule,
    HttpClientModule,
    FlexLayoutModule,
    ReactiveFormsModule,
  ],
  exports: [
    FormsModule,
    CommonModule,
    RouterModule,
    TranslateModule,
    FlexLayoutModule,
    ReactiveFormsModule,
  ],
})
export class SharedModule { }


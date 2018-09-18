import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';

import {OtherDatatableRoutingModule} from './other-datatable-routing.module';
import {OtherDatatableComponent} from './other-datatable.component';
import {DataTableModule} from 'angular2-datatable';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpModule} from '@angular/http';
import {SharedModule} from '../../../../shared/shared.module';

@NgModule({
  imports: [
    CommonModule,
    OtherDatatableRoutingModule,
    SharedModule,
    HttpModule,
    DataTableModule,
    FormsModule,
    ReactiveFormsModule
  ],
  declarations: [OtherDatatableComponent]
})
export class OtherDatatableModule {
}

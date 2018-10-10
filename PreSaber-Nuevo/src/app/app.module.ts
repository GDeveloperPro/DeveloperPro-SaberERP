import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {SharedModule} from './shared/shared.module';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';

import {routing, appRoutingProviders} from "./app.rounting";
import {FormsModule} from "@angular/forms";
import {HttpClientModule} from "@angular/common/http";


import {AppComponent} from './app.component';
import {CKEditorModule} from "ng2-ckeditor";
import {SafeHtmlPipe} from "./services/tanfromarHtml";
import {LoginComponent} from './components/login/login.component';
import {HomeAdminSistemasComponent} from './components/administradorSistemas/home-admin-sistemas/home-admin-sistemas.component';
import {CrearUsuariosComponent} from './components/administradorSistemas/crear-usuarios/crear-usuarios.component';
import {CrearPermisosComponent} from './components/administradorSistemas/crear-permisos/crear-permisos.component';
import {CrearMenuComponent} from './components/administradorSistemas/crear-menu/crear-menu.component';
import {AdministrarMenuComponent} from './components/administradorSistemas/administrar-menu/administrar-menu.component';

import {CrearRolComponent} from './components/administradorSistemas/crear-rol/crear-rol.component';
import {ValidarPaginaComponent} from "./components/validar-pagina/validar-pagina.component";
import {ServiceWorkerModule} from '@angular/service-worker';
import {environment} from '../environments/environment';
import {CalendarModule, DateAdapter} from 'angular-calendar';
import {adapterFactory} from 'angular-calendar/date-adapters/date-fns';
import { FlatpickrModule } from 'angularx-flatpickr';

@NgModule({
  declarations: [

  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    SharedModule,
    routing,
    FormsModule,
    HttpClientModule,
    CKEditorModule,
    FlatpickrModule.forRoot(),
    CalendarModule.forRoot({
      provide: DateAdapter,
      useFactory: adapterFactory
    }),
    ServiceWorkerModule.register('ngsw-worker.js', {enabled: environment.production}),

  ],
  providers: [appRoutingProviders],
  bootstrap: [AppComponent]
})
export class AppModule {
}

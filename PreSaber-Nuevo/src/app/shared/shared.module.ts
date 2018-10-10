import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';

import 'd3';
import 'nvd3';

import {MenuItems} from './menu-items/menu-items';
import {AccordionAnchorDirective, AccordionLinkDirective, AccordionDirective} from './accordion';
import {ToggleFullscreenDirective} from './fullscreen/toggle-fullscreen.directive';
import {CardRefreshDirective} from './card/card-refresh.directive';
import {CardToggleDirective} from './card/card-toggle.directive';
import {CardComponent} from './card/card.component';
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import {ParentRemoveDirective} from './elements/parent-remove.directive';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {ModalAnimationComponent} from './modal-animation/modal-animation.component';
import {ModalBasicComponent} from './modal-basic/modal-basic.component';
import {ToastyModule} from 'ng2-toasty';
import {SimpleNotificationsModule} from 'angular2-notifications';
import {TagInputModule} from 'ngx-chips';
import {AnimatorModule} from 'css-animator';
import {ColorPickerModule} from 'ngx-color-picker';
import {CurrencyMaskModule} from 'ng2-currency-mask';
import {SelectModule} from 'ng-select';
import {SelectOptionService} from './elements/select-option.service';
import {FormWizardModule} from 'angular2-wizard';
import {NgxDatatableModule} from '@swimlane/ngx-datatable';
import {DataFilterPipe} from './elements/data-filter.pipe';
import {DataTableModule} from 'angular2-datatable';
import {FroalaEditorModule, FroalaViewModule} from 'angular-froala-wysiwyg';
import {FileUploadModule} from 'ng2-file-upload';
import {ScrollToModule} from '@nicky-lenaers/ngx-scroll-to';
import {AgmCoreModule} from '@agm/core';
import {Ng2GoogleChartsModule} from 'ng2-google-charts';
import {NgxEchartsModule} from 'ngx-echarts';
import {UiSwitchModule} from 'ng2-ui-switch/dist';
import {ChartModule} from 'angular2-chartjs';
import {KnobModule} from 'ng2-knob';
import {NvD3Module} from 'ng2-nvd3';
import {TodoService} from './todo/todo.service';
import {ClickOutsideModule} from 'ng-click-outside';
import {SpinnerComponent} from './spinner/spinner.component';
import {PERFECT_SCROLLBAR_CONFIG, PerfectScrollbarConfigInterface, PerfectScrollbarModule} from 'ngx-perfect-scrollbar';
import {NotificationsService} from 'angular2-notifications';
import {ChartistModule} from 'ng-chartist';
import {appRoutingProviders, routing} from "../app.rounting";
import {AppComponent} from "../app.component";
import {CrearUsuariosComponent} from "../components/administradorSistemas/crear-usuarios/crear-usuarios.component";
import {CrearRolComponent} from "../components/administradorSistemas/crear-rol/crear-rol.component";
import {LoginComponent} from "../components/login/login.component";
import {ValidarPaginaComponent} from "../components/validar-pagina/validar-pagina.component";
import {SafeHtmlPipe} from "../services/tanfromarHtml";
import {CrearPermisosComponent} from "../components/administradorSistemas/crear-permisos/crear-permisos.component";
import {AdministrarMenuComponent} from "../components/administradorSistemas/administrar-menu/administrar-menu.component";
import {CrearMenuComponent} from "../components/administradorSistemas/crear-menu/crear-menu.component";
import {HomeAdminSistemasComponent} from "../components/administradorSistemas/home-admin-sistemas/home-admin-sistemas.component";
import {ServiceWorkerModule} from "@angular/service-worker";
import {environment} from "../../environments/environment";
import { CalendarModule, DateAdapter } from 'angular-calendar';
import { adapterFactory } from 'angular-calendar/date-adapters/date-fns';
import { FlatpickrModule } from 'angularx-flatpickr';

const DEFAULT_PERFECT_SCROLLBAR_CONFIG: PerfectScrollbarConfigInterface = {
  suppressScrollX: true
};

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    NgbModule.forRoot(),
    ToastyModule.forRoot(),
    SimpleNotificationsModule.forRoot(),
    TagInputModule,
    UiSwitchModule,
    AnimatorModule,
    ColorPickerModule,
    SelectModule,
    CurrencyMaskModule,
    FormWizardModule,
    NgxDatatableModule,
    routing,
    DataTableModule,
    FroalaEditorModule.forRoot(),
    FroalaViewModule.forRoot(),
    FlatpickrModule.forRoot(),
    FileUploadModule,
    ScrollToModule.forRoot(),
    AgmCoreModule.forRoot({apiKey: 'AIzaSyCE0nvTeHBsiQIrbpMVTe489_O5mwyqofk'}),
    ServiceWorkerModule.register('ngsw-worker.js', { enabled: environment.production }),
    Ng2GoogleChartsModule,
    NgxEchartsModule,
    ChartModule,
    KnobModule,
    NvD3Module,
    ClickOutsideModule,
    CalendarModule.forRoot({
      provide: DateAdapter,
      useFactory: adapterFactory
    }),
    PerfectScrollbarModule,
    ChartistModule
  ],
  declarations: [
    AccordionAnchorDirective,
    AccordionLinkDirective,
    AccordionDirective,
    ToggleFullscreenDirective,
    CardRefreshDirective,
    CardToggleDirective,
    ParentRemoveDirective,
    CardComponent,
    SpinnerComponent,
    ModalAnimationComponent,
    ModalBasicComponent,
    DataFilterPipe,
    AppComponent,
    SafeHtmlPipe,
    LoginComponent,
    HomeAdminSistemasComponent,
    CrearUsuariosComponent,
    CrearPermisosComponent,
    CrearMenuComponent,
    AdministrarMenuComponent,
    CrearRolComponent,
    ValidarPaginaComponent
  ],
  exports: [
    AccordionAnchorDirective,
    AccordionLinkDirective,
    AccordionDirective,
    ToggleFullscreenDirective,
    CardRefreshDirective,
    CardToggleDirective,
    ParentRemoveDirective,
    CardComponent,
    SpinnerComponent,
    NgbModule,
    FormsModule,
    ReactiveFormsModule,
    ModalBasicComponent,
    ModalAnimationComponent,
    ToastyModule,
    SimpleNotificationsModule,
    TagInputModule,
    UiSwitchModule,
    AnimatorModule,
    ColorPickerModule,
    SelectModule,
    CurrencyMaskModule,
    FormWizardModule,
    NgxDatatableModule,
    DataTableModule,
    DataFilterPipe,
    FroalaEditorModule,
    FroalaViewModule,
    FileUploadModule,
    ScrollToModule,
    AgmCoreModule,
    Ng2GoogleChartsModule,
    NgxEchartsModule,
    ChartModule,
    KnobModule,
    NvD3Module,
    ClickOutsideModule,
    PerfectScrollbarModule,
    ChartistModule
  ],
  providers: [
    MenuItems,
    TodoService,
    appRoutingProviders,
    SelectOptionService,
    NotificationsService,
    {
      provide: PERFECT_SCROLLBAR_CONFIG,
      useValue: DEFAULT_PERFECT_SCROLLBAR_CONFIG
    }
  ]
})
export class SharedModule {
}

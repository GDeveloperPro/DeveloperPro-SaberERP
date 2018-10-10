import {ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule} from "@angular/router";



import {LoginComponent} from "./components/login/login.component";
import {HomeAdminSistemasComponent} from "./components/administradorSistemas/home-admin-sistemas/home-admin-sistemas.component";
import {CrearUsuariosComponent} from "./components/administradorSistemas/crear-usuarios/crear-usuarios.component";
import {CrearPermisosComponent} from "./components/administradorSistemas/crear-permisos/crear-permisos.component";
import {CrearMenuComponent} from "./components/administradorSistemas/crear-menu/crear-menu.component";
import {AdministrarMenuComponent} from "./components/administradorSistemas/administrar-menu/administrar-menu.component";
import {CrearRolComponent} from "./components/administradorSistemas/crear-rol/crear-rol.component";
import {ValidarPaginaComponent} from "./components/validar-pagina/validar-pagina.component";


const appRoutes: Routes = [

  {path: '', component: ValidarPaginaComponent, pathMatch: 'full'},
  {path: '👑/💻/🏠', component: HomeAdminSistemasComponent},
  {path: '👑/💻/crear/👦', component: CrearUsuariosComponent},
  {path: '👑/💻/crearPermisos', component: CrearPermisosComponent},
  {path: '👑/💻/administrarMenu', component: AdministrarMenuComponent},
  {path: '👑/💻/crearMenus', component: CrearMenuComponent},
  {path: '👑/nuevoRol', component: CrearRolComponent},
  //Rutas distribuidor
  {path: 'login', component: LoginComponent},
  {path: '**', component: ValidarPaginaComponent}

];

export const appRoutingProviders: any[] = [];
export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);

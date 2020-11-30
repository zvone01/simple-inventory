import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './home';
import { ProductComponent } from './product';
import { UploadfileComponent } from './uploadfile';
/*import { MachineViewComponent } from './machine-view/';
import { MachineEditComponent } from './machine-edit/';
import { UserViewComponent } from './user-view/';
import { TemplateItemsComponent } from './template-items';
import { LoginComponent } from './login';
import { RegisterComponent } from './register';
import { MachineTemplatesComponent } from './machine-templates/';
import { AuthGuard } from './_guards/index';*/

const routes: Routes = [
  { path: '', component: HomeComponent },
  { path: 'uploadfile', component: UploadfileComponent },
  { path: 'product/:id', component: ProductComponent },
 /* { path: 'machinesV', component: MachineViewComponent, canActivate: [AuthGuard]},
  { path: 'machinesE', component: MachineEditComponent, canActivate: [AuthGuard] },
  { path: 'usersV', component: UserViewComponent, canActivate: [AuthGuard] },
  { path: 'machine/:id', component: MachineTemplatesComponent, canActivate: [AuthGuard] },
  { path: 'templateI/:id', component: TemplateItemsComponent, canActivate: [AuthGuard] },
  { path: 'login', component: LoginComponent },
  { path: 'register', component: RegisterComponent, canActivate: [AuthGuard] },*/
  { path: '**', redirectTo: '' }
];


@NgModule({
  imports: [RouterModule.forRoot(routes, { relativeLinkResolution: 'legacy' })],
  exports: [RouterModule]
})
export class AppRoutingModule { }
import { Routes } from '@angular/router';
import { CreateUserComponent } from './components/adminpanel/createuser/createuser.component';
import { AdminComponent } from './layouts/admin/admin.component';

export const routes: Routes = [
    {path:"admin" ,component:AdminComponent,children:[
        {path:"createUser" , component:CreateUserComponent

        },
    ]}
];
// poner ruta por si pones una inexistente que te redirija (**)
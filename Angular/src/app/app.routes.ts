import { Routes } from '@angular/router';
import { CreateUserComponent } from './components/adminpanel/createuser/createuser.component';
import { AdminComponent } from './layouts/admin/admin.component';
import { PatientComponent } from './layouts/patient/patient.component';
import { SignupComponent } from './components/patientpanel/signup/signup.component';
import { SigninComponent } from './components/patientpanel/signin/signin.component';

export const routes: Routes = [
    {path:"admin" ,component:AdminComponent,children:[
        { path: '', redirectTo: 'create_user', pathMatch: 'full' },
        {path:"create_user" , component:CreateUserComponent
            

        },
    ]}
    ,
  //  {path:"patient/sign_up", component: SignupComponent},
     {path:"patient" ,component:PatientComponent,children:[
        { path: '', redirectTo: 'sign_up', pathMatch: 'full' },
        {path:"sign_up" , component:SignupComponent},
        {path:"sign_in" , component:SigninComponent},

    ]}
];
// poner ruta por si pones una inexistente que te redirija (**)
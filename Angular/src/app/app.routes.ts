import { Routes } from '@angular/router';
import { CreateUserComponent } from './components/adminpanel/createuser/createuser.component';
import { AdminComponent } from './layouts/admin/admin.component';
import { PatientComponent } from './layouts/patient/patient.component';
import { SignupComponent } from './components/patientpanel/signup/signup.component';
import { SigninComponent } from './components/patientpanel/signin/signin.component';
import { HomeComponent } from './components/patientpanel/home/home.component';
import { CreatetreatmentComponent } from './components/adminpanel/createtreatment/createtreatment.component';
import { AppointmenthistoryComponent } from './components/patientpanel/appointmenthistory/appointmenthistory.component';
import { ShowappointmentsComponent } from './components/adminpanel/showappointments/showappointments.component';
import { ReceptionistComponent } from './layouts/receptionist/receptionist.component';
import { ShowusersComponent } from './components/receptionistpanel/showusers/showusers.component';


export const routes: Routes = [
    {path:"admin" ,component:AdminComponent,children:[
        { path: '', redirectTo: 'sign_in', pathMatch: 'full' },
        {path:"create_user" , component:CreateUserComponent},
        {path:"create_treatment" , component:CreatetreatmentComponent},
        {path:"get_all_appointments",component:ShowappointmentsComponent}
    ]}
    ,
     {path:"patient" ,component:PatientComponent,children:[
        { path: '', redirectTo: 'sign_in', pathMatch: 'full' },
        {path:"sign_up" , component:SignupComponent},
        {path:"sign_in" , component:SigninComponent},
        {path:"home" , component:HomeComponent},
        {path:"AppointmentsHistory", component:AppointmenthistoryComponent}

    ]},
    {path:'receptionist' ,component:ReceptionistComponent,children:[
        { path: '', redirectTo: 'sign_in', pathMatch: 'full' },
        {path: 'show_users' , component:ShowusersComponent}
        
    ]}
];
// poner ruta por si pones una inexistente que te redirija (**)
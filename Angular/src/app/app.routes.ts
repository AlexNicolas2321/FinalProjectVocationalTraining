import { Routes } from '@angular/router';

import { CreateUserComponent } from './components/adminpanel/createuser/createuser.component';
import { AdminComponent } from './layouts/admin/admin.component';
import { PatientComponent } from './layouts/patient/patient.component';
import { DoctorComponent } from './layouts/doctor/doctor.component';
import { ReceptionistComponent } from './layouts/receptionist/receptionist.component';

import { SignupComponent } from './components/patientpanel/signup/signup.component';
import { SigninComponent } from './components/patientpanel/signin/signin.component';
import { HomeComponent } from './components/patientpanel/home/home.component';
import { AppointmenthistoryComponent } from './components/patientpanel/appointmenthistory/appointmenthistory.component';
import { ShowusersComponent } from './components/receptionistpanel/showusers/showusers.component';
import { ModifiedappointmentsComponent } from './components/receptionistpanel/modifiedappointments/modifiedappointments.component';
import { CreateroleComponent } from './components/adminpanel/createrole/createrole.component';
import { EditeUserRolesComponent } from './components/adminpanel/editeuser/editeuser.component';
import { AdministratetreatmentsComponent } from './components/doctorpanel/administratetreatments/administratetreatments.component';
import { AppointmentsviewComponent } from './components/doctorpanel/appointmentsview/appointmentsview.component';


export const routes: Routes = [
    {path:"admin" ,component:AdminComponent,children:[
        { path: '', redirectTo: 'sign_in', pathMatch: 'full' },
        {path:"create_user" , component:CreateUserComponent},
        {path:"create_role",component:CreateroleComponent},
        {path: "edite_user_roles", component:EditeUserRolesComponent}
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
        {path: 'show_users' , component:ShowusersComponent},
        {path: "show_appointments",component:ModifiedappointmentsComponent},
        
    ]},
    {path:'doctor' ,component:DoctorComponent,children:[
        { path: '', redirectTo: 'sign_in', pathMatch: 'full' },
        {path: 'show_patients' , component:ShowusersComponent},
        {path: 'administrate_treatments' , component:AdministratetreatmentsComponent},
        {path: 'view_appointments' , component:AppointmentsviewComponent},

        
    ]},
];
// poner ruta por si pones una inexistente que te redirija (**)
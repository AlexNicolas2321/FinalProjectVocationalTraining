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
import { ChatboxComponent } from './components/patientpanel/chatbox/chatbox.component';
import { NutritionComponent } from './components/patientpanel/nutrition/nutrition.component';
import { ExerciseComponent } from './components/patientpanel/exercise/exercise.component';
import { StatisticsComponent } from './components/adminpanel/statistics/statistics.component';

import { AdminGuard } from './guards/admin.guard';
import { PatientGuard } from './guards/patient.guard';
import { ReceptionistGuard } from './guards/receptionist.guard';
import { DoctorGuard } from './guards/doctor.guard';

export const routes: Routes = [
  {
    path: 'admin',
    component: AdminComponent,
    canActivate: [AdminGuard],
    canActivateChild: [AdminGuard],
    children: [
      { path: '', redirectTo: 'create_user', pathMatch: 'full' },
      { path: 'create_user', component: CreateUserComponent },
      { path: 'create_role', component: CreateroleComponent },
      { path: 'edite_user_roles', component: EditeUserRolesComponent },
      { path: 'sign_up', component: SignupComponent },
      { path: 'sign_in', component: SigninComponent },
      { path: 'statistics', component: StatisticsComponent },
    ],
  },
  {
    path: 'patient',
    component: PatientComponent,
    children: [
      { path: '', redirectTo: 'home', pathMatch: 'full' },
      { path: 'sign_up', component: SignupComponent },
      { path: 'sign_in', component: SigninComponent },
      { path: 'home', component: HomeComponent },
      { path: 'AppointmentsHistory', component: AppointmenthistoryComponent },
      { path: 'chatBox', component: ChatboxComponent },
      { path: 'nutrition', component: NutritionComponent },
      { path: 'exercise', component: ExerciseComponent },
    ],
  },
  {
    path: 'receptionist',
    component: ReceptionistComponent,
    canActivate: [ReceptionistGuard],
    canActivateChild: [ReceptionistGuard],
    children: [
      { path: '', redirectTo: 'show_appointments', pathMatch: 'full' },
      { path: 'show_users', component: ShowusersComponent },
      { path: 'show_appointments', component: ModifiedappointmentsComponent },
    ],
  },
  {
    path: 'doctor',
    component: DoctorComponent,
    canActivate: [DoctorGuard],
    canActivateChild: [DoctorGuard],
    children: [
      { path: '', redirectTo: 'show_patients', pathMatch: 'full' },
      { path: 'show_patients', component: ShowusersComponent },
      { path: 'administrate_treatments', component: AdministratetreatmentsComponent },
      { path: 'view_appointments', component: AppointmentsviewComponent },
    ],
  },
  // Ruta para página no autorizada
{ path: 'unauthorized', redirectTo: '/patient/home', pathMatch: 'full' },
  // Ruta catch-all 
  { path: '**', redirectTo: 'unauthorized' },
];

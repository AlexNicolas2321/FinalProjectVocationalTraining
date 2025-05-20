import { Component } from '@angular/core';
import { SidebarPatientComponent } from '../../components/patientpanel/sidebar-patient/sidebar-patient.component';
import { RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-patient',
  imports: [SidebarPatientComponent,RouterOutlet],
  templateUrl: './patient.component.html',
  styleUrl: './patient.component.css'
})
export class PatientComponent {

}

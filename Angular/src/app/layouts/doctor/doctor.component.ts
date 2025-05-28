import { Component } from '@angular/core';
import { SidebarDoctorComponent } from '../../components/doctorpanel/sidebar-doctor/sidebar-doctor.component';
import { RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-doctor',
  imports: [SidebarDoctorComponent,RouterOutlet],
  templateUrl: './doctor.component.html',
  styleUrl: './doctor.component.css'
})
export class DoctorComponent {

}

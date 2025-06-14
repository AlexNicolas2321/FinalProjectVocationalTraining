import { Component } from '@angular/core';
import { AppointmentService } from '../../../services/appointment.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { jwtDecode } from 'jwt-decode';

interface AppointmentData {
  id: number;
  date: string;
  first_name: string;
  last_name: string;
  treatment: string;
  user_dni:string;
  patient_first_name:string;
  doctor_last_name:string;
  doctor_first_name:string;
  patient_last_name:string;
  patient_phone:string;
  state:string;
  editing:boolean;
  newStatus:string;
}
@Component({
  selector: 'app-appointmentsview',
  imports: [CommonModule,FormsModule],
  templateUrl: './appointmentsview.component.html',
  styleUrl: './appointmentsview.component.css'
})
export class AppointmentsviewComponent {
  appointments: AppointmentData[] = [];
  editingAppointment: AppointmentData | null = null;
  dni: string = '';
  allAppointments: AppointmentData[] = [];
  
  constructor(private appointmentService: AppointmentService) {}

  ngOnInit() {
    this.loadAppointmentHistory();
  }

  loadAppointmentHistory() {
    const token = localStorage.getItem("token");
    if (token) {
      const user_id = jwtDecode<any>(token).user_id;
      this.appointmentService.getSpecificAppointmentsDoctor(user_id).subscribe({
        next: (data: AppointmentData[]) => {
          this.appointments = data;
          this.allAppointments = data;
          console.log('Appointments obtained', this.appointments);
        },
        error: (err) => {
          console.error('Error getting appointments', err);
        },
      });
    }
  }
  
  refreshList(): void {
    this.appointments = this.allAppointments;
    this.dni = '';
  }
  
  searchPatient(): void {
    const trimmedDni = this.dni.trim();
    if (!trimmedDni) {
      this.appointments = this.allAppointments;
      return;
    }
  
    this.appointments = this.allAppointments.filter(
      appt => appt.user_dni && appt.user_dni.includes(trimmedDni)
    );
  }
 
}

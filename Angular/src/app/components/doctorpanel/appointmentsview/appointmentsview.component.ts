import { Component } from '@angular/core';
import { AppointmentService } from '../../../services/appointment.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

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

  constructor(private appointmentService: AppointmentService) {}

  ngOnInit() {
    this.loadAppointmentHistory();
  }

  loadAppointmentHistory() {
    this.appointmentService.getAllAppointments().subscribe({
      next: (data: AppointmentData[]) => {
        this.appointments = data;
        console.log('Appointments obtained', this.appointments);
      },
      error: (err) => {
        console.error('Error getting appointments', err);
      },
    });
  }

 
}

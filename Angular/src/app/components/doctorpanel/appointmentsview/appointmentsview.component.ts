import { Component } from '@angular/core';
import { AppointmentService } from '../../../services/appointment.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

interface AppointmentData {
  id: number;
  date: string;
  observations?: string;
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

  editAppointment(appointment: AppointmentData) {
    // Creamos una copia para evitar modificar la lista directamente hasta guardar
    this.editingAppointment = { ...appointment };
  }

  saveObservation() {
    if (this.editingAppointment) {
      const obs = this.editingAppointment.observations || '';
      this.appointmentService.editeAppointmentObservation(this.editingAppointment.id, obs).subscribe({
        next: () => {
          // Actualizamos en la lista local
          const index = this.appointments.findIndex(a => a.id === this.editingAppointment!.id);
          if (index !== -1) {
            this.appointments[index].observations = obs;
          }
          this.editingAppointment = null;
          console.log('Appointment observation updated successfully');
        },
        error: (err) => {
          console.error('Error updating appointment observation', err);
        }
      });
    }
  }

  cancelEdit() {
    this.editingAppointment = null;
  }
}

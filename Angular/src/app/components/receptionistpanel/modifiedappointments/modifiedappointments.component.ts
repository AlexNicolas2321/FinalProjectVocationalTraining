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
  email:string;
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
  selector: 'app-modifiedappointments',
  imports: [CommonModule,FormsModule],
  templateUrl: './modifiedappointments.component.html',
  styleUrl: './modifiedappointments.component.css'
})
export class ModifiedappointmentsComponent {

  constructor(private appointmentService:AppointmentService
  ){}

 
  dni: string = '';
  allAppointments: AppointmentData[] = [];
    
  appointments: AppointmentData[] = [];
  
  ngOnInit(){
    this.loadAppointmentHistory();
    
  }


  loadAppointmentHistory() {
    this.appointmentService.getAllAppointments().subscribe({
      next: (data: AppointmentData[]) => {
        this.appointments = data;
        this.allAppointments = data;
        console.log('tratamientos obtenidos', this.appointments);      
      },
      error: err => console.error('Error al obtener tratamientos', err)
    });
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
  updateStatus(id: number, status: string) {
    this.appointmentService.editeAppointmentStatus(id, status).subscribe({
      next: (res) => {
       // console.log(id);
        const appointment = this.appointments.find(a => a.id === id);
        if (appointment) {
          appointment.state = status;
          appointment.editing = false;  
        }
       

        console.log('Appointment updated successfully');
      },
      error: (err) => {
        
      }
    });
  }
  
  

  downloadPdf(appointmentId: number) {
    this.appointmentService.getAppointmentPdf(appointmentId).subscribe({
      next: (blob) => {
        const fileURL = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = fileURL;
        a.download = `appointment_${appointmentId}.pdf`;
        a.click();
        window.URL.revokeObjectURL(fileURL);
      },
      error: (err) => {
        console.error('Error al descargar PDF:', err);
      }
    });
  }
  

}

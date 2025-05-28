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
  selector: 'app-modifiedappointments',
  imports: [CommonModule,FormsModule],
  templateUrl: './modifiedappointments.component.html',
  styleUrl: './modifiedappointments.component.css'
})
export class ModifiedappointmentsComponent {

  constructor(private appointmentService:AppointmentService
  ){}

 
  
  appointments: AppointmentData[] = [];
  
  ngOnInit(){
    this.loadAppointmentHistory();
    
  }

  loadAppointmentHistory(){
    this.appointmentService.getAllAppointments().subscribe({
      next : ($data : AppointmentData[])=>{
        this.appointments=$data;
        console.log('tratamientos obtenidos',this.appointments);      
      },
      error : err =>{ console.error('Error al obtener tratamientos', err)

      }

      
    })
  }

  updateStatus(id: number, status: string) {
    this.appointmentService.editeAppointmentStatus(id, status).subscribe({
      next: (res) => {
        // Por ejemplo, actualizar el estado en tu array local para reflejar el cambio inmediatamente
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
    
}

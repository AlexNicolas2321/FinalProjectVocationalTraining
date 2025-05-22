import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { AppointmentService } from '../../../services/appointment.service';
import { OnInit } from '@angular/core';

interface AppointmentData {
  id: number;
  date: string;
  observations?: string;
  first_name: string;
  last_name: string;
  treatment: string;
}

@Component({
  selector: 'app-showappointments',
  imports: [CommonModule,FormsModule],
  templateUrl: './showappointments.component.html',
  styleUrl: './showappointments.component.css'
})
export class ShowappointmentsComponent {
  constructor(private appointmentService:AppointmentService){}

 
  
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

}

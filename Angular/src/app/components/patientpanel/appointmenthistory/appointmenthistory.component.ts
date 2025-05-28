import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { AppointmentService } from '../../../services/appointment.service';
import { OnInit } from '@angular/core';
import { jwtDecode } from 'jwt-decode';

interface AppointmentData {
  id: number;
  date: string;
  observations?: string;
  first_name: string;
  last_name: string;
  treatment: string;
  state:string;
}

@Component({
  selector: 'app-appointmenthistory',
  imports: [CommonModule,FormsModule],
  templateUrl: './appointmenthistory.component.html',
  styleUrl: './appointmenthistory.component.css'
})


export class AppointmenthistoryComponent implements OnInit{

  constructor(private appointmentService:AppointmentService){}

 
  
  appointments: AppointmentData[] = [];
  
  ngOnInit(){
    this.loadAppointmentHistory();
    
  }

  loadAppointmentHistory(){
    let token=(localStorage.getItem("token"));
    if(token){
      let user_id = jwtDecode<any>(token).user_id;
      
     this.appointmentService.getSpecificAppointments(user_id).subscribe({
      next : ($data : AppointmentData[])=>{
        this.appointments=$data;
        console.log('tratamientos obtenidos',this.appointments);      
      },
      error : err =>{ console.error('Error al obtener tratamientos', err)

      }

      
    })
    }    
 
  }





}

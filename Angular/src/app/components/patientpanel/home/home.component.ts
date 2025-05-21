import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { jwtDecode } from 'jwt-decode';
import { TreatmentService } from '../../../services/treatment.service';
import { Treatment } from '../../../models/treatment';

@Component({
  imports:[CommonModule,FormsModule],
  selector: 'app-home',
  templateUrl: './home.component.html'
})
export class HomeComponent implements OnInit {
  userId: string = '';
  fecha: string = '';
  minFecha: string = '';
  horasDisponibles: string[] = ['09:00', '10:00', '11:00', '12:00', '16:00', '17:00'];
  horasSeleccionadas: string[] = [];
  horaSeleccionada: string = '';
  treatments: Treatment[] = [];


  constructor (private treatmentService: TreatmentService){};

  ngOnInit(): void {
    this.setMinFecha();
    this.decodeToken();
  
    this.treatmentService.getAllTreatments().subscribe({
      next: (data: Treatment[]) => {
        this.treatments = data; 
      },
      error: err => console.error('Error al obtener tratamientos', err)
    });
  
  }





  setMinFecha(): void {
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    this.minFecha = tomorrow.toISOString().split('T')[0];
  }

  decodeToken(): void {
    const token = localStorage.getItem('token');
    if (token) {
      const decoded: any = jwtDecode(token);
      this.userId = decoded.user_id;
      console.log('User ID:', this.userId);
    }
  }

  toggleHora(hora: string, event: any): void {
    if (event.target.checked) {
      this.horasSeleccionadas.push(hora);
    } else {
      this.horasSeleccionadas = this.horasSeleccionadas.filter(h => h !== hora);
    }
  }

  submitForm(): void {
    const cita = {
      patientId: this.userId,
      fecha: this.fecha,
      hora: this.horaSeleccionada,
      observations?: null,
      doctorId: ;
      treatmentId: ;
    };
  
    console.log('Cita enviada:', cita);
    // Aquí enviarías los datos al backend
  }
  
}

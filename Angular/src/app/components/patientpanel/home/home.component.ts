import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { jwtDecode } from 'jwt-decode';
import { TreatmentService } from '../../../services/treatment.service';
import { Treatment } from '../../../models/treatment';
import { AppointmentService } from '../../../services/appointment.service';

@Component({
  imports: [CommonModule, FormsModule],
  selector: 'app-home',
  templateUrl: './home.component.html'
})
export class HomeComponent implements OnInit {
  userId: number = 10;
  fecha: string = '';
  minFecha: string = '';
  horasDisponibles: string[] = ['09:00', '10:00', '11:00', '12:00', '16:00', '17:00'];
  horasSeleccionadas: string[] = [];
  horaSeleccionada: string = '';
  treatments: Treatment[] = [];
  doctorId: number = 0;
  selectedTreatmentId: number = 0;
  message: string = '';
  error: string = '';

  constructor(
    private treatmentService: TreatmentService,
    private appointmentService: AppointmentService
  ) {}

  ngOnInit(): void {
    this.setMinFecha();
    this.decodeToken();

    this.treatmentService.getAllTreatments().subscribe({
      next: (data: Treatment[]) => {
        this.treatments = data;
        this.treatments.forEach(treatment =>{
          if(treatment.name="Limpieza Bucal"){
            treatment.img="http://localhost:8000/img/limpieza_bucal.jpg";
          }else if(treatment.name="Cita"){
            treatment.img="http://localhost:8000/img/cita.jpg";

          }else if(treatment.name="Ortodoncia"){
            treatment.img="http://localhost:8000/img/ortodoncia.jpg";

          }
        })
        console.log('Tratamientos obtenidos:', this.treatments);
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
    this.selectedTreatmentId = Number(this.selectedTreatmentId); // Asegura que sea número

    console.log('ID seleccionado:', this.selectedTreatmentId);

    const selectedTreatment = this.treatments.find(t => t.id === this.selectedTreatmentId);

    if (!selectedTreatment) {
      this.error = 'Tratamiento no encontrado';
      this.message = '';
      console.error(this.error);
      return;
    }
console.log(selectedTreatment);
    if (selectedTreatment.doctorId === null || selectedTreatment.doctorId === undefined) {
      this.error = 'El tratamiento no tiene un doctor asignado';
      this.message = '';
      console.error(this.error);
      return;
    }

    this.doctorId = selectedTreatment.doctorId;

    const fechaCompleta = `${this.fecha}T${this.horaSeleccionada}:00`;

    const appointment = {
      userId: this.userId,
      date: fechaCompleta,
      observations: null,
      doctorId: this.doctorId,
    };

    console.log('Cita enviada:', appointment);

    this.appointmentService.createAppointment(appointment).subscribe({
      next: res => {
        this.message = '¡Cita pedida!';
        this.error = '';
        console.log('Respuesta del servidor:', res);
      },
      error: err => {
        this.error = 'Error al pedir cita: ' + (err.error?.error || 'Servidor no disponible');
        this.message = '';
        console.error(this.error);
      }
    });
  }
}

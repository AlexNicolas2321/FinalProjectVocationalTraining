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
  selectedTreatmentId: number = 0 ;
  message: string = '';
  error: string = '';
  isPatient: boolean = false;

  constructor(
    private treatmentService: TreatmentService,
    private appointmentService: AppointmentService
  ) { }

  ngOnInit(): void {
    this.setMinFecha();
    this.decodeToken();
    this.isPatient = this.hasPatientRole(); 


    this.treatmentService.getAllTreatments().subscribe({
      next: (data: Treatment[]) => {
        this.treatments = data;
        this.treatments.forEach(treatment => {
          if (treatment.name == "limpieza_bucal") {
            treatment.img = "http://localhost:8000/img/limpieza_bucal.jpg";
          }
          if (treatment.name == "plantillas_ortopédicas") {
            treatment.img = "http://localhost:8000/img/plantillas_ortopedicas.jpg";

          }
          if (treatment.name === "revisión_auditiva") {
            treatment.img = "http://localhost:8000/img/revision_auditiva.jpg";

          }
        })
        console.log('Tratamientos obtenidos:', this.treatments);
      },
      error: err => console.error('Error al obtener tratamientos', err)
    });
  }
  formatTreatmentName(name: string): string {
    // Reemplaza guiones bajos por espacios
    const nameWithSpaces = name.replace(/_/g, ' ');
    
    // Capitaliza solo la primera letra de toda la cadena
    return nameWithSpaces.charAt(0).toUpperCase() + nameWithSpaces.slice(1);
  }
  
  
  hasPatientRole(): boolean {
    const token = localStorage.getItem('token');
    if (!token) return false;
  
    try {
      const decoded: any = jwtDecode(token);
      return decoded.roles?.includes('ROLE_PATIENT');
    } catch {
      return false;
    }
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
  selectTreatment(treatmentId: number): void {
    this.selectedTreatmentId = treatmentId;
    this.fecha = this.minFecha;          // Fecha mínima por defecto
    this.horaSeleccionada = '';          // Limpia la hora seleccionada
    this.message = '';
    this.error = '';
    this.fecha = '';

  }
  
  submitForm(): void {
    this.selectedTreatmentId = Number(this.selectedTreatmentId);
  
    const selectedTreatment = this.treatments.find(t => t.id === this.selectedTreatmentId);
  
    if (!selectedTreatment) {
      this.error = 'Tratamiento no encontrado';
      this.message = '';
      return;
    }
  
    if (selectedTreatment.doctorId === null || selectedTreatment.doctorId === undefined) {
      this.error = 'El tratamiento no tiene un doctor asignado';
      this.message = '';
      return;
    }
  
    this.doctorId = selectedTreatment.doctorId;
    const fechaCompleta = `${this.fecha}T${this.horaSeleccionada}:00`;
  
    const appointment = {
      userId: this.userId,
      date: fechaCompleta,
      doctorId: this.doctorId,
    };
  
    this.appointmentService.createAppointment(appointment).subscribe({
      next: res => {
        this.message = '¡Cita pedida!';
        this.error = '';
        console.log('Respuesta del servidor:', res);
  
        // Cierra el modal
        const modalEl = document.getElementById('appointmentModal');
        if (modalEl) {
          (modalEl as any).classList.remove('show');
          (modalEl as any).setAttribute('aria-hidden', 'true');
          (modalEl as any).style.display = 'none';
          const modalBackdrop = document.querySelector('.modal-backdrop');
          if (modalBackdrop) modalBackdrop.remove();
          document.body.classList.remove('modal-open');
          document.body.style.removeProperty('padding-right');
        }
      },
      error: err => {
        this.error = 'Error al pedir cita: ' + (err.error?.error || 'Servidor no disponible');
        this.message = '';
      }
    });
  }
  
}

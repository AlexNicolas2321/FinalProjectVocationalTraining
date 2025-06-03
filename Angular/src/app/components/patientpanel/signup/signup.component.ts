// src/app/signup/signup.component.ts
import { Component } from '@angular/core';
import { AuthenticationService } from '../../../services/authentication.service'; 
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-signup',
  imports: [FormsModule, CommonModule],
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent {
  formData: any = {
    email: '',
    password: '',
    dni: '',
    first_name: '',
    last_name: '',
    phone: '',
    birth_date: '',
    created_at:""
  };

  birthDateInvalid = false;
  message = '';
  error = '';

  constructor(private authenticationService: AuthenticationService) {}

  validateBirthDate() {
    const birthDateStr = this.formData.birth_date;
    if (!birthDateStr) {
      this.birthDateInvalid = false;
      return;
    }

    const birthDate = new Date(birthDateStr);

    const maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() - 110);

    const minDate = new Date();
    minDate.setFullYear(minDate.getFullYear() - 5);

    this.birthDateInvalid =
      birthDate < maxDate || birthDate > minDate;
  }

  onSubmit() {
    this.validateBirthDate();

    if (this.birthDateInvalid) {
      this.error = 'La fecha de nacimiento no es válida.';
      this.message = '';
      return;
    }

    if (!this.formData.email || !this.formData.password) {
      this.error = 'Por favor, rellena los campos obligatorios.';
      this.message = '';
      return;
    }

    if (this.formData.dni && this.formData.dni.length !== 9) {
      this.error = 'El DNI debe tener exactamente 9 caracteres.';
      this.message = '';
      return;
    }

    if (this.formData.password.length < 7) {
      this.error = 'La contraseña debe tener al menos 7 caracteres.';
      this.message = '';
      return;
    }

    this.formData.created_at= new Date();
    this.authenticationService.signUp(this.formData).subscribe({
      next: () => {
        this.error = '';
        this.message = '¡Registro exitoso!';
      },
      error: () => {
        this.error = 'No se pudo registrar el usuario.';
        this.message = '';
      }
    });
  }
}

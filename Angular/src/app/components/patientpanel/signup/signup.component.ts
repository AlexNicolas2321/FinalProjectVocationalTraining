// src/app/signup/signup.component.ts
import { Component } from '@angular/core';
import { AuthenticationService } from '../../../services/authentication.service'; 
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import dayjs from 'dayjs';

@Component({
  selector: 'app-signup',
  imports: [FormsModule, CommonModule],
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent {
  formData = {
    email: '',
    password: '',
    dni: '',
    first_name: '',
    last_name: '',
    phone: '',
    birth_date: '',
    created_at: ''  // lo rellenamos en ngOnInit
  };

  message = '';
  error = '';

  constructor(private authService: AuthenticationService) {}

  ngOnInit() {
    this.formData.created_at = dayjs().format('YYYY-MM-DD HH:mm:ss');

  }

  onSubmit() {
    this.authService.signUp(this.formData).subscribe({
      next: (res) => {
        this.message = '¡Registro exitoso!';
        this.error = '';
      },
      error: (err) => {
        this.error = 'Error en el registro: ' + (err.error.error || 'Servidor no disponible');
        this.message = '';
      }
    });
  }
}

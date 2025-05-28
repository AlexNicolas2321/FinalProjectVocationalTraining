import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { AuthenticationService } from '../../../services/authentication.service';
import { Router } from '@angular/router';
import { jwtDecode } from 'jwt-decode';

@Component({
  selector: 'app-signin',
  imports: [FormsModule, CommonModule],
  templateUrl: './signin.component.html',
  styleUrl: './signin.component.css'
})
export class SigninComponent {
  
  constructor (private authenticationService:AuthenticationService, private router:Router){}

  credentials={
    dni:"",
    password:"",
  }
  error:string="";

  onSubmit(){
    this.authenticationService.signIn(this.credentials).subscribe({
      next: (res) => {
        console.log('Response from API:', res); // <-- para verificar qué trae exactamente
        if (res.token && typeof res.token === 'string') {
          localStorage.setItem('token', res.token);
          const decodedToken = jwtDecode(res.token);
          console.log('Decoded token:', decodedToken);
          // this.router.navigate(['/']);
        } else {
          console.error('Token is missing or not a string');
          this.error = 'Token inválido recibido';
        }
      },
      error: (err) => {
        this.error = err.error?.message || 'Login failed';
      }
    });
    
  }
}

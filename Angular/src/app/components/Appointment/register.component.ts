import { Component } from '@angular/core';
import { RegisterService } from '../../services/register.service';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-register',
  imports: [FormsModule],
  templateUrl: './appointment.component.html',
  styleUrl: './register.component.css'
})
export class RegisterComponent {
  
  numeroSeguro: string = '';
  correo: string = '';
  dni: string = '';
  telefono: number |null=null;
  nombre: string = '';
  apellidos: string = '';
  password: string = '';
  confirmPassword: string = '';
  fechaNacimiento: Date | null = null;

  constructor(private service:RegisterService){}

  sendData(){
  let json=    {
      "numeroSeguro": this.numeroSeguro,
      "correo": this.correo,
      "dni": this.dni,
      "telefono": this.telefono,
      "nombre": this.nombre,
      "apellidos": this.apellidos,
      "password": this.password,
      "confirmPassword": this.confirmPassword,
      "fechaNacimiento": this.fechaNacimiento
    }
    
      this.service.getUsers(json).subscribe(response => {
        console.log(response);
      });
  }
}

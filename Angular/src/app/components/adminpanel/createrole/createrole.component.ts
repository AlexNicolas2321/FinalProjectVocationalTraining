import { Component, OnInit } from '@angular/core';
import { UserService } from '../../../services/user.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-createrole',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './createrole.component.html',
  styleUrls: ['./createrole.component.css']
})
export class CreateroleComponent implements OnInit {

  roles: any[] = [];
  name: string = '';
  message: string = '';
  messageType: 'success' | 'error' | '' = ''; 

  constructor(private userService: UserService) {}

  ngOnInit(): void {
    this.loadRoles();
  }

  loadRoles() {
    this.userService.getAllRoles().subscribe({
      next: res => {
        this.roles = res;
      },
      error: err => {
        console.error('Error loading roles:', err);
      }
    });
  }
  onInputChange() {
    this.message = '';
    this.messageType = '';
  }
  
  createRole() {
    const trimmedName = this.name.trim();
  
    if (!trimmedName) {
      this.message = 'Por favor, ingresa un nombre válido para el rol.';
      this.messageType = 'error';
      return;
    }
  
    this.userService.createRole(trimmedName).subscribe({
      next: res => {
        this.message = '¡Rol creado exitosamente!';
        this.messageType = 'success';
        this.name = '';
        this.loadRoles(); // actualizar lista
      },
      error: err => {
        console.error('Error creating role:', err);
        this.message = 'Error al crear el rol.';
        this.messageType = 'error';
      }
    });
  }  

}

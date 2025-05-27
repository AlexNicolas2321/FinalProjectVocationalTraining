import { Component, OnInit } from '@angular/core';
import { UserService } from '../../../services/user.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Modal } from 'bootstrap';

@Component({
  selector: 'app-createrole',
  imports: [CommonModule, FormsModule],
  templateUrl: './editeuser.component.html',
  styleUrls: ['./editeuser.component.css']
})
export class EditeUserRolesComponent implements OnInit {

  users: any[] = [];
  allRoles: any[] = []; 
  selectedUser: any = null;
  editRolesModal: any;

  constructor(private userService: UserService) {}

  ngOnInit(): void {
    this.loadUsers();
    this.loadAllRoles();
  }

  loadUsers() {
    this.userService.getAllUsers().subscribe({
      next: res => {
        this.users = res;
      },
      error: err => {
        console.error('Error cargando usuarios', err);
      }
    });
  }

  loadAllRoles() {
    this.userService.getAllRoles().subscribe({
      next: res => {
        this.allRoles = res.map((r: any) => ({ name: r.name, selected: false }));
      },
      error: err => {
        console.error('Error cargando roles', err);
      }
    });
  }

  openEditRolesModal(user: any) {
    this.selectedUser = user;

    // Marcar los roles que el usuario ya tiene
    this.allRoles.forEach(role => {
     if(user.roleNames.includes(role.name)){
      role.selected = true;
     }
      
    });

    const modalElement = document.getElementById('editRolesModal');
    this.editRolesModal = new Modal(modalElement!);
    this.editRolesModal.show();
  }

  submitEditRoles() {
    // Obtener los roles seleccionados
    const selectedRoles = this.allRoles.filter(r => r.selected=true).map(r => r.name);

    // Llamar a la función editeRoleUsers
    this.userService.editeRoleUsers(this.selectedUser.id, selectedRoles).subscribe({
      next: res => {
        console.log('Roles actualizados', res);
        this.editRolesModal.hide();
        this.loadUsers(); // refrescar lista de usuarios
      },
      error: err => {
        console.error('Error al actualizar roles', err);
      }
    });
  }
}

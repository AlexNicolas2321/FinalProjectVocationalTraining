import { Component, OnInit } from '@angular/core';
import { UserService } from '../../../services/user.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

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

  // Control del modal sin Bootstrap JS
  isModalOpen = false;

  constructor(private userService: UserService) {}

  ngOnInit(): void {
    this.loadUsers();
    this.loadAllRoles();
  }

  loadUsers() {
    this.userService.getAllUsers().subscribe({
      next: res => this.users = res,
      error: err => console.error('Error cargando usuarios', err)
    });
  }

  loadAllRoles() {
    this.userService.getAllRoles().subscribe({
      next: res => {
        this.allRoles = res.map((r: any) => ({ name: r.name, selected: false }));
      },
      error: err => console.error('Error cargando roles', err)
    });
  }

  openEditRolesModal(user: any) {
    this.selectedUser = user;

    // Marcar los roles que el usuario ya tiene
    this.allRoles.forEach(role => {
      role.selected = user.roleNames.includes(role.name);
    });

    this.isModalOpen = true;  // Abrir modal
  }

  closeModal() {
    this.isModalOpen = false;  // Cerrar modal
  }

  submitEditRoles() {
    const selectedRoles = this.allRoles.filter(r => r.selected).map(r => r.name);

    this.userService.editeRoleUsers(this.selectedUser.id, selectedRoles).subscribe({
      next: res => {
        console.log('Roles actualizados', res);
        this.closeModal();
        this.loadUsers(); // refrescar lista de usuarios
      },
      error: err => console.error('Error al actualizar roles', err)
    });
  }
}

  import { Component, OnInit } from '@angular/core';
  import { UserService } from '../../../services/user.service';
  import { User } from '../../../models/user';
  import { CommonModule } from '@angular/common';
  import { FormsModule } from '@angular/forms';


  @Component({
    selector: 'app-create-user',
    imports:[CommonModule,FormsModule],
    templateUrl: './createuser.component.html'
  })
  export class CreateUserComponent implements OnInit {
    users: User[] = [];
    roles: any[] = [];
    
    created_user:User={
      id: 0,
      dni: '',
      password:'',
      user_type: '',
      first_name: '',
      last_name: '',
      roleIds: [],
      phone:'',
      speciality:""
    }
    constructor(private userService: UserService) {}

    ngOnInit(): void {
      this.userService.getAllUsers().subscribe({
        next: (data: any[]) => {
          this.users = data.map(user => ({
            id: user.id,
            dni: user.dni,
            roleNames: user.roleNames.split(','),
            first_name:user.first_name,
            last_name:user.last_name,
            user_type:user.user_type,
          }));
        },
        error: err => console.error('Error al obtener usuarios', err)
      });

      this.userService.getAllRoles().subscribe({
        next: (data) => {
          this.roles = data;
        },
        error: (err) => console.error('Error al obtener roles', err)
      });
    }

    createUser() {
      const baseUser = {
        dni: this.created_user.dni,
        roles: this.created_user.roleIds,
        user_type: this.created_user.user_type,
        password: this.created_user.password
      };
    
      if (this.created_user.user_type === 'admin') {
        this.userService.createAdmin(baseUser).subscribe({
          next: () => console.log('Admin creado correctamente'),
          error: (err) => console.error('Error al crear admin', err)
        });
      } else {
        const extendedData: any = {
          ...baseUser,
          first_name: this.created_user.first_name,
          last_name: this.created_user.last_name,
          phone: this.created_user.phone
        };
    
        // Solo si es doctor, añadimos la especialidad
        if (this.created_user.user_type === 'doctor') {
          extendedData.speciality = this.created_user.speciality;
        }
    
        this.userService.createUserWithDetails(extendedData).subscribe({
          next: () => console.log('Usuario creado correctamente'),
          error: (err) => console.error('Error al crear usuario', err)
        });
      }
    }
    
    onRoleChange(event: Event) {
      const checkbox = event.target as HTMLInputElement;
      const roleId = Number(checkbox.value);
    
      // Asegurar que roleIds existe
      if (!this.created_user.roleIds) {
        this.created_user.roleIds = [];
      }
    
      if (checkbox.checked) {
        if (!this.created_user.roleIds.includes(roleId)) {
          this.created_user.roleIds.push(roleId);
        }
      } else {
        this.created_user.roleIds = this.created_user.roleIds.filter(id => id !== roleId);
      }
    }
    
    
  }
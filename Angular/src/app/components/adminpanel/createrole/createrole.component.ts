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

  createRole() {
    const trimmedName = this.name.trim();

    if (!trimmedName) {
      this.message = 'Please enter a valid role name.';
      this.messageType = 'error';
      return;
    }

    this.userService.createRole(trimmedName).subscribe({
      next: res => {
        this.message = 'Role created successfully!';
        this.messageType = 'success';
        this.name = '';
        this.loadRoles(); // actualizar lista
      },
      error: err => {
        console.error('Error creating role:', err);
        this.message = 'Failed to create role.';
        this.messageType = 'error';
      }
    });
  }

}

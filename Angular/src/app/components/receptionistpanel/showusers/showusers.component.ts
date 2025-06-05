import { Component, OnInit } from '@angular/core';
import { UserService } from '../../../services/user.service';
import { CommonModule } from '@angular/common';
import { User } from '../../../models/user';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-showusers',
  imports: [CommonModule, FormsModule],
  templateUrl: './showusers.component.html',
  styleUrls: ['./showusers.component.css']
})
export class ShowusersComponent implements OnInit {

  showUserLists: boolean = true;
  dni: string = '';
  users: User[] = [];        
  allUsers: User[] = [];

  constructor(private userService: UserService) {}

  ngOnInit(): void {
    this.userService.getAllPatients().subscribe({
      next: (data: User[]) => {
        this.users = data;       
        this.allUsers = data;
      },
      error: err => console.error('Error al obtener usuarios', err)
    });
  }

  showUserList() {
    this.showUserLists = true;
  }

  refreshList(): void {
    this.users = this.allUsers;
    this.dni = '';
  }
  
  searchPatient(): void {
    const trimmedDni = this.dni.trim();
    if (!trimmedDni) {
      this.users = this.allUsers;
      return;
    }

    this.userService.getUserByDni(trimmedDni).subscribe({
      next: (res: User[]) => {
        this.users = res;     
        this.dni = '';
      },
      error: err => {
        console.error('Paciente no encontrado', err);
        this.users = [];
        this.dni = '';
      }
    });
  }
}

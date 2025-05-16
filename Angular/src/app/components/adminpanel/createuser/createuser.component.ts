import { Component, OnInit } from '@angular/core';
import { UserService } from '../../../services/user.service';
import { User } from '../../../models/user';
import { CommonModule } from '@angular/common';


@Component({
  selector: 'app-create-user',
  imports:[CommonModule],
  templateUrl: './createuser.component.html'
})
export class CreateUserComponent implements OnInit {
  users: User[] = [];

  constructor(private userService: UserService) {}

  ngOnInit(): void {
    this.userService.getAllUsers().subscribe({
      next: (data: any[]) => {
        this.users = data.map(user => ({
          id: user.id,
          dni: user.dni,
          roleNames: user.roleNames.split(',')
        }));
      },
      error: err => console.error('Error al obtener usuarios', err)
    });
  }
}
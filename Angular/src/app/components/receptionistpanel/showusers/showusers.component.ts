import { Component, OnInit } from '@angular/core';
import { UserService } from '../../../services/user.service';
import { CommonModule } from '@angular/common';
import { User } from '../../../models/user';
@Component({
  selector: 'app-showusers',
  imports: [CommonModule],
  templateUrl: './showusers.component.html',
  styleUrl: './showusers.component.css'
})
export class ShowusersComponent implements OnInit {

  users:User[]=[];
  constructor(private userService:UserService){}
  ngOnInit(): void {
    this.userService.getAllUsers().subscribe({
      next: (data: any[]) => {
        this.users=data;
      },
      error: err => console.error('Error al obtener usuarios', err)
    });
}

}

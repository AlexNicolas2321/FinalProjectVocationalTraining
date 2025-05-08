import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Home } from '../../../services/Home.service';
import { Speciality } from '../../../models/speciality.model';
import { Role } from '../../../models/role.model';
import { User } from '../../../models/user.model';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-create-user',
  imports: [FormsModule,CommonModule],
  templateUrl: './Home.component.html',
  styleUrl: './Home.component.css'
})
export class HomeComponent {
  
  specialties: Speciality[] = [];
  roles:Role[]=[]
  users:User[]=[]

  id? : number;
  dni: string='';
  password: string='';
  name:string='';
  

  constructor(
    private createuser:Home,    
  ){
    
  }

  ngOnInit() {
    this.createuser.getAllSpecialities().subscribe(data => {
      this.specialties = data;
    
    });

    this.createuser.getAllRoles().subscribe(data => {
      this.roles = data;
    
    });

    
    this.createuser.getAllUsers().subscribe(data => {
      this.users = data;
    
    });
  }
  

}

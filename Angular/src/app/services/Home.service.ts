import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { User } from '../models/user.model';
import { Speciality } from '../models/speciality.model';
import { Role } from '../models/role.model';

@Injectable({
  providedIn: 'root'
})
export class Home {
  private baseUrl = 'http://localhost:8000/api/';

  constructor(private http:HttpClient) {}

  getAllUsers(){
    return this.http.get<User[]>(this.baseUrl+"getAllUsers");
  }
  getAllSpecialities(){
    return this.http.get<Speciality[]>(this.baseUrl+"getAllSpecialities");
  }
  getAllRoles(){
    return this.http.get<Role[]>(this.baseUrl+"getAllRoles");

  }
}

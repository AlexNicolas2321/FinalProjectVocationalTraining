import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { User } from '../models/user';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  private apiUrl = 'http://localhost:8000/api/'; // Ajusta si usas otro puerto

  constructor(private http: HttpClient) {}

  getAllUsers(): Observable<User[]> {
    return this.http.get<User[]>(this.apiUrl+"getAllUsers");
  }
  getAllPatients(): Observable<any> {
    return this.http.get<any>(this.apiUrl+"getAllPatients");
  }
  getAllRoles(): Observable<any> {
    return this.http.get<any>(this.apiUrl+"getAllRoles");
  }
  
  createAdmin(userData: any): Observable<any> {
    return this.http.post(`${this.apiUrl}admin`, userData);
  }

  createUserWithDetails(userData: any): Observable<any> {
    return this.http.post(`${this.apiUrl}notAdmin`, userData);
  }

  createRole(name:string): Observable<any>{
    return this.http.post(`${this.apiUrl}createRole`,{name});
  }

  editeRoleUsers(id:number,role:string[]) : Observable<any>{
    return this.http.patch(`${this.apiUrl}editRoleUser`,{id,role})
  }

  getUserByDni(dni:string): Observable<any>{
    return this.http.get(`${this.apiUrl}getUserByDni/${dni}`,)
  }
}

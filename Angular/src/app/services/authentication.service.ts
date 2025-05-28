// src/app/services/authentication.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { User } from '../models/user';
import { Router } from '@angular/router';


@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  private apiUrl = 'http://localhost:8000/api'; // Ajusta la URL según tu backend

  constructor(private http: HttpClient,private router:Router) {}

  signUp(data: User): Observable<any> {
    return this.http.post(`${this.apiUrl}/signUp`, data);
  }

  signIn(credentials: { dni: string; password: string }): Observable<any> {
    return this.http.post(`${this.apiUrl}/signIn`, credentials);
  }
  logout(){
    localStorage.clear();
    this.router.navigate(['/patient/sign_in']);
  }
}

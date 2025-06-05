// src/app/services/authentication.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, tap } from 'rxjs';
import { User } from '../models/user';
import { Router } from '@angular/router';
import { BehaviorSubject } from 'rxjs';


@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  private isLoggedInSubject = new BehaviorSubject<boolean>(this.hasToken());
  isLoggedIn$ = this.isLoggedInSubject.asObservable();

  private apiUrl = 'http://localhost:8000/api'; // Ajusta la URL según tu backend

  constructor(private http: HttpClient,private router:Router) {}

  private hasToken(): boolean {
    return !!localStorage.getItem('token');
  }
  signUp(data: User): Observable<any> {
    return this.http.post(`${this.apiUrl}/signUp`, data);
  }

  signIn(credentials: { dni: string; password: string }): Observable<any> {
    return this.http.post(`${this.apiUrl}/signIn`, credentials).pipe(
      tap((response: any) => {
        localStorage.setItem('token', response.token);
        this.isLoggedInSubject.next(true);
        this.router.navigate(['/patient/home']);
      })
    );
  }

  logout(): void {
    localStorage.clear();
    this.isLoggedInSubject.next(false);
    this.router.navigate(['/patient/sign_in']);
  }
}

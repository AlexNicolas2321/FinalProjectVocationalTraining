import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RegisterService {
  private apiUrl = 'http://localhost:8000/api/register';  // URL de la API de Symfony

  constructor(private http: HttpClient) { }

  getUsers(parameter:any): Observable<any> {
    return this.http.post(this.apiUrl,parameter);
  }
}

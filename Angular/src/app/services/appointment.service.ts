import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Appointment } from '../models/appointment';


@Injectable({
  providedIn: 'root'
})
export class AppointmentService {

  private apiUrl = 'http://localhost:8000/api/'; 

  constructor(private http: HttpClient) {}

  createAppointment(appointment: Appointment): Observable<Appointment> {
    return this.http.post<Appointment>(`${this.apiUrl}createAppointment`, appointment);
  }
  getAllAppointments(): Observable<any[]>{
    return this.http.get<any[]>(`${this.apiUrl}getAllAppointments`);
  }
  getSpecificAppointments(id: number): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}getSpecificAppointments/${id}`);
  }
  getSpecificAppointmentsDoctor(id: number): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}getSpecificAppointmentsDoctor/${id}`);
  }
  editeAppointmentStatus(id:number,status:string) : Observable<any>{
    return this.http.patch<any>(`${this.apiUrl}editeAppointmentStatus/${id}`, {status});
  }
  editeAppointmentObservation(id:number,observation:string): Observable<any>{
    return this.http.patch<any>(`${this.apiUrl}editeAppointmentObservation/${id}`,{observation});
  }

  getAppointmentPdf(id: number) {
    return this.http.get(`${this.apiUrl}appointments/${id}/pdf`, { responseType: 'blob' });
  }
  cancelAppointment(id:number): Observable<any>{
    return this.http.patch<any>(`${this.apiUrl}cancelAppointment/${id}`,{})
  }
  
}

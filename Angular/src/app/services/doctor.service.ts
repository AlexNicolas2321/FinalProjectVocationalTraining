import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Doctor } from '../models/doctor';

@Injectable({
  providedIn: 'root'
})
export class DoctorService {


  private api="http://localhost:8000/api/";
  constructor(private http:HttpClient) { }

 

  getAllDoctors() : Observable<Doctor[]>{
  return this.http.get<Doctor[]>(this.api+"getAllDoctors");
  }}

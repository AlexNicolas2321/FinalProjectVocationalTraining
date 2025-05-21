import { Injectable } from '@angular/core';
import { Treatment} from '../models/treatment';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class TreatmentService {

  private api="http://localhost:8000/api/";
  constructor(private http:HttpClient) { }

  createTreatment(treatment: Treatment): Observable<any> {
    return this.http.post(`${this.api}createTreatment`, treatment);
  }

  getAllTreatments() : Observable<Treatment[]>{
  return this.http.get<Treatment[]>(this.api+"getAllTreatments");
  }
}

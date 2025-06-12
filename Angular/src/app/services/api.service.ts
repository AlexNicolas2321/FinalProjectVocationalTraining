import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  
  private apiUrl = 'http://localhost:8000/api/'; 

  constructor(private http: HttpClient) { }

  getNutritionFood(food: string): Observable<any[]>{
    return this.http.get<any[]>(`${this.apiUrl}nutrition/${food}`);
  }
  getExerciseData(activity: string, duration_minutes: number, weight_kg: number): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}exercise`, {activity,duration_minutes,weight_kg});
  }

  getStatistics(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}statistics`);
  }
}

import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { ApiService } from '../../../services/api.service';

@Component({
  selector: 'app-nutrition',
  imports: [CommonModule,FormsModule],
  templateUrl: './nutrition.component.html',
  styleUrl: './nutrition.component.css'
})
export class NutritionComponent {
 
  food: string = '';
  nutritionData: any[] = [];
  loading: boolean = false;
  error: string | null = null;

  constructor(private apiService: ApiService) {}


  searchNutrition() {
    if (!this.food.trim()) return;

    this.loading = true;
    this.error = null;
    this.nutritionData = [];
    this.apiService.getNutritionFood(this.food).subscribe({
      next: data => {
        this.nutritionData = data;
        this.loading = false;
      },
      error: err => {
        this.error = 'Error al cargar los datos';
        this.loading = false;
      }
    })
  }
}

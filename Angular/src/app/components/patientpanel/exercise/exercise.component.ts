import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { ApiService } from '../../../services/api.service';

interface ExerciseCalorie {
  name: string;
  calories_per_hour: number;
  duration_minutes: number;
  total_calories: number;
}

@Component({
  selector: 'app-exercise',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './exercise.component.html',
  styleUrls: ['./exercise.component.css']
})
export class ExerciseComponent {
  activity = '';
  duration = 30;
  weight = 70;
  loading = false;
  error = '';
  result: { calories: ExerciseCalorie[] } | null = null;

  constructor(private exerciseService: ApiService) {}

  searchExercise() {
    if (!this.activity.trim()) {
      this.error = 'Por favor, ingresa una actividad válida.';
      return;
    }

    this.loading = true;
    this.error = '';
    this.result = null;

    this.exerciseService.getExerciseData(this.activity, this.duration, this.weight).subscribe({
      next: data => {
        this.result = data;
        this.loading = false;
      },
      error: () => {
        this.error = 'Error al obtener los datos.';
        this.loading = false;
      }
    });
  }
}

import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ApiService } from '../../../services/api.service';

@Component({
  selector: 'app-statistics',
  standalone: true,
  imports: [CommonModule, FormsModule],  
  templateUrl: './statistics.component.html',
  styleUrls: ['./statistics.component.css']
})
export class StatisticsComponent implements OnInit {

  constructor(private statisticsService: ApiService) {}

  dataApi: any = {};



  ngOnInit(): void {
    this.statisticsService.getStatistics().subscribe({
      next: (data) => {
        this.dataApi = data;
        const labels = data.treatmentStats.map((t: any) => t.name);
        const counts = data.treatmentStats.map((t: any) => t.usage_count);

     
      },
      error: (err) => {
        console.error('Error cargando estadísticas', err);
      }
    });
  }
}

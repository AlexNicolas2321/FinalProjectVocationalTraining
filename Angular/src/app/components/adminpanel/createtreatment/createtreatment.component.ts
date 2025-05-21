import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { TreatmentService } from '../../../services/treatment.service';
import { Treatment } from '../../../models/treatment';
@Component({
  selector: 'app-createtreatment',
  imports: [CommonModule,FormsModule],
  templateUrl: './createtreatment.component.html',
  styleUrl: './createtreatment.component.css'
})
export class CreatetreatmentComponent {

constructor(private treatmentService : TreatmentService){}

  newTreatment:Treatment={
    name:'',
    description:'',
    price:0,
  }

  createTreatment(){

    this.treatmentService.createTreatment(this.newTreatment).subscribe({

      next: (data) =>{
        console.log("usuario creado"+data);
      },
      error: (err) =>{
        console.log("error",err);
      }

      
    })
  }
}

import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { TreatmentService } from '../../../services/treatment.service';
import { Treatment } from '../../../models/treatment';
import { DoctorService } from '../../../services/doctor.service';
import { Doctor } from '../../../models/doctor';

@Component({
  selector: 'app-createtreatment',
  imports: [CommonModule,FormsModule],
  templateUrl: './createtreatment.component.html',
  styleUrl: './createtreatment.component.css'
})
export class CreatetreatmentComponent {

  doctors: Doctor[]=[];
  selectedDoctorId: number | null = null;
 
constructor(private treatmentService : TreatmentService, private doctorService: DoctorService){}


newTreatment: Treatment = {
  name: '',
  description: '',
  price: 0,
  doctorId: null
};

ngOnInit(){
  this.doctorService.getAllDoctors().subscribe({
    next: (data) =>{
      this.doctors=data;
    },
    error: (err) =>{
      console.log("error",err);
    }
  })
}
 

  createTreatment(){

   const newTreatment:Treatment={
      name:this.newTreatment.name,
      description:this.newTreatment.description,
      price:this.newTreatment.price,
      doctorId: this.selectedDoctorId
    }

    this.treatmentService.createTreatment(newTreatment).subscribe({

      next: (data) =>{
        console.log("usuario creado"+data);
      },
      error: (err) =>{
        console.log("error",err);
      }

      
    })
  }
}

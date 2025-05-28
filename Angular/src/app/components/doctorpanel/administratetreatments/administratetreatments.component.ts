import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { TreatmentService } from '../../../services/treatment.service';
import { Doctor } from '../../../models/doctor';
import { DoctorService } from '../../../services/doctor.service';
import { Treatment } from '../../../models/treatment';


@Component({
  selector: 'app-administratetreatments',
  imports: [CommonModule,FormsModule],
  templateUrl: './administratetreatments.component.html',
  styleUrl: './administratetreatments.component.css'
})
export class AdministratetreatmentsComponent {

  
  doctors: Doctor[]=[];
  selectedDoctorId: number | null = null;
 
constructor(private treatmentService : TreatmentService, private doctorService: DoctorService){}

  treatments: Treatment[] = [];
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

  this.treatmentService.getAllTreatments().subscribe({
    next : data =>{
      this.treatments= data;    
    } ,
    error : err =>{
      console.log("error traer treatments",err);
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

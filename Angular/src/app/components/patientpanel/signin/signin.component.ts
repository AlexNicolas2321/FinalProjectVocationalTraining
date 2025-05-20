import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { AuthenticationService } from '../../../services/authentication.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-signin',
  imports: [FormsModule,CommonModule],
  templateUrl: './signin.component.html',
  styleUrl: './signin.component.css'
})
export class SigninComponent {
  
  constructor (private authenticationService:AuthenticationService, private router:Router){}

  credentials={
    dni:"",
    password:"",
  }
  error:string="";

  onSubmit(){
    this.authenticationService.signIn(this.credentials).subscribe({
      next :(res) =>{
        localStorage.setItem("token",res.token);
        //this.router.navigate(["/"])

      },
      error : (err) =>{
        this.error=err.error?.message || "login failed";
      }
      
    })
  }
}

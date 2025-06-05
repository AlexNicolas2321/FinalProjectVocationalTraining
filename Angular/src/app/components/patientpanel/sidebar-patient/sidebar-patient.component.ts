import { Component, OnInit } from '@angular/core';
import { RouterModule } from '@angular/router';
import { AuthenticationService } from '../../../services/authentication.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { jwtDecode } from 'jwt-decode';

@Component({
  selector: 'app-sidebar-patient',
  imports: [RouterModule,CommonModule,FormsModule],
  templateUrl: './sidebar-patient.component.html',
  styleUrl: './sidebar-patient.component.css'
})
export class SidebarPatientComponent implements OnInit {

  constructor(private authenticationService:AuthenticationService){
    this.decodeToken();

  }
  
  isLoggedIn: boolean = false;
  hasToken = false;
  userId: string | null = null;

  ngOnInit(): void {
    this.authenticationService.isLoggedIn$.subscribe((status) => {
      this.isLoggedIn = status;
    });
  }
 
  decodeToken(): void {
    const token = localStorage.getItem('token');
    if (token) {
      const decoded: any = jwtDecode(token);
      this.userId = decoded.user_id;
      this.hasToken = true;
      console.log('User ID:', this.userId);
    } else {
      this.hasToken = false;
    }
  }

  
  logout(){
    this.authenticationService.logout();
    this.hasToken = false;
  }
}

import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { AuthenticationService } from '../../../services/authentication.service';

@Component({
  selector: 'app-sidebar-doctor',
  imports: [RouterModule],
  templateUrl: './sidebar-doctor.component.html',
  styleUrl: './sidebar-doctor.component.css'
})
export class SidebarDoctorComponent {

  constructor(private AuthenticationService:AuthenticationService){}

  logout(){
    this.AuthenticationService.logout();
  }
}

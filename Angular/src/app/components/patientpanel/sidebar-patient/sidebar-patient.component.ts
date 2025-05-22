import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { AuthenticationService } from '../../../services/authentication.service';

@Component({
  selector: 'app-sidebar-patient',
  imports: [RouterModule],
  templateUrl: './sidebar-patient.component.html',
  styleUrl: './sidebar-patient.component.css'
})
export class SidebarPatientComponent {

  constructor(private authenticationSerive:AuthenticationService){}

  logout(){
    this.authenticationSerive.logout();
  }
}

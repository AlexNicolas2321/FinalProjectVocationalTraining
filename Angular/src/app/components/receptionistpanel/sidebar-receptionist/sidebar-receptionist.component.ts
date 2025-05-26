import { Component } from '@angular/core';
import { AuthenticationService } from '../../../services/authentication.service';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-sidebar-receptionist',
  imports: [RouterModule],
  templateUrl: './sidebar-receptionist.component.html',
  styleUrl: './sidebar-receptionist.component.css'
})
export class SidebarReceptionistComponent {

  constructor(private AuthenticationService:AuthenticationService){}

  logout(){
    this.AuthenticationService.logout();
  }
}

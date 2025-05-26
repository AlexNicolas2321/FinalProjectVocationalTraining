import { Component } from '@angular/core';
import { SidebarReceptionistComponent } from '../../components/receptionistpanel/sidebar-receptionist/sidebar-receptionist.component';
import { RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-receptionist',
  imports: [SidebarReceptionistComponent,RouterOutlet],
  templateUrl: './receptionist.component.html',
  styleUrl: './receptionist.component.css'
})
export class ReceptionistComponent {

}

import { Component } from '@angular/core';

@Component({
  selector: 'app-navbar',
  standalone: true,
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent {
 

  onSearch(event: Event) {
    const input = event.target as HTMLInputElement;
    console.log('🔍 Buscando:', input.value);
    // Aquí podrías emitir un evento o llamar a un servicio
  }
}

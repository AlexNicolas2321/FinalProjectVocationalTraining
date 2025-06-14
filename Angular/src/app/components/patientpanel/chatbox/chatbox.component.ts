import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-chatbox',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './chatbox.component.html',
  styleUrl: './chatbox.component.css'
})
export class ChatboxComponent {
  faqs = [
    {
      question: '¿Qué debo llevar a mi cita?',
      answer: 'Solo necesitas tu DNI y llegar 10 minutos antes.',
      expanded: false
    },
    {
      question: '¿Puedo cancelar una cita?',
      answer: 'Sí, puedes hacerlo desde tu historial de citas.',
      expanded: false
    },
    {
      question: '¿Cómo se paga?',
      answer: 'El pago se realiza en recepción, en efectivo o tarjeta.',
      expanded: false
    },
    {
      question: '¿Cuándo recibo la factura?',
      answer: 'Inmediatamente después de pagar se le entregará una copia física, además de mandarsele a su correo digitalmente en el caso de tener el correo registrado.',
      expanded: false
    }
  ];

  toggle(faq: any): void {
    faq.expanded = !faq.expanded;
  }
}

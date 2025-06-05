import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-chatbox',
  imports: [CommonModule,FormsModule],
  templateUrl: './chatbox.component.html',
  styleUrl: './chatbox.component.css'
})
export class ChatboxComponent {
  messages = [{ sender: 'bot', text: 'Hola 👋 ¿En qué puedo ayudarte?' }];

  options = [
    '¿Qué debo llevar a mi cita?',
    '¿Puedo cancelar una cita?',
    '¿Cómo se paga?',
    '¿Cuando recibo la factura?'
  ];

  handleClick(question: string): void {
    this.messages.push({ sender: 'user', text: question });

    const responses: Record<string, string> = {
      '¿Qué debo llevar a mi cita?': 'Solo necesitas tu DNI y llegar 10 minutos antes.',
      '¿Puedo cancelar una cita?': 'Sí, puedes hacerlo desde tu historial de citas',
      '¿Cómo se paga?': 'El pago se realiza en recepción, en efectivo o tarjeta.',
      '¿Cuando recibo la factura?':'Inmediatamente despues de pagar se le entregará una copia física , ademas de mandarsele a su correo digitalmente.'
    };

    const reply = responses[question] || 'Lo siento, no tengo una respuesta para eso.';
    setTimeout(() => {
      this.messages.push({ sender: 'bot', text: reply });
    }, 500);
  }
}

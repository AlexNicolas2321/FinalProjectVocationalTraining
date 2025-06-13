<?php

    namespace App\Service;
    
    use App\Entity\Appointment;
    use App\Entity\Invoice;
    use Doctrine\ORM\EntityManagerInterface;
    use Dompdf\Dompdf;
    use Dompdf\Options;

    
    class createInvoiceService
    {
        private EntityManagerInterface $entityManager;
    
        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->entityManager = $entityManager;
        }
    
        public function createInvoiceForAppointment(Appointment $appointment): Invoice
{
    $doctor = $appointment->getDoctor();
    $patient = $appointment->getPatient();
    $treatment = $doctor->getTreatment();

    $invoice = new Invoice();
    $invoice->setAppointment($appointment);
    $invoice->setIssuedAt(new \DateTimeImmutable());
    $invoice->setBaseAmount($treatment->getPrice());
    $invoice->setTaxRate(21); // 21% VAT
    $invoice->setStatus("confirmed");

    // Calculate the amounts
    $basePrice = $invoice->getBaseAmount();
    $taxAmount = $basePrice * ($invoice->getTaxRate() / 100);
    $totalAmount = $basePrice + $taxAmount;

    $invoice->setTaxAmount($taxAmount);
    $invoice->setTotalAmount($totalAmount);

    $this->entityManager->persist($invoice);
    $this->entityManager->flush();

    $patientName = $patient->getFirstName() . ' ' . $patient->getLastName();
    $doctorName = $doctor->getFirstName() . ' ' . $doctor->getLastName();
    $treatmentName = $doctor->getTreatment()->getName();

    $pdfBinaryContent = $this->generatePdf($invoice, $patientName,$doctorName,$treatmentName);
    $invoice->setPdfFile($pdfBinaryContent);

    $this->entityManager->flush(); 

    return $invoice;
}




private function generatePdf(Invoice $invoice, string $patientName, string $doctorName, string $treatmentName): string
{
    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);

    $html = '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 14px;
                color: #333;
                margin: 30px;
            }
            h1 {
                text-align: center;
                color: #2E86C1;
                margin-bottom: 40px;
            }
            .invoice-header {
                margin-bottom: 30px;
            }
            .invoice-header p {
                margin: 4px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 30px;
            }
            th, td {
                padding: 12px;
                border: 1px solid #ddd;
                text-align: right;
            }
            th {
                background-color: #f2f2f2;
                text-align: left;
            }
            .total-row th, .total-row td {
                font-weight: bold;
                border-top: 2px solid #000;
            }
            .footer {
                text-align: center;
                font-size: 12px;
                color: #666;
                margin-top: 40px;
            }
        </style>
    </head>
    <body>
        <h1>Factura</h1>

        <div class="invoice-header">
            <p><strong>Paciente:</strong> ' . htmlspecialchars($patientName) . '</p>
            <p><strong>Facultativo:</strong> ' . htmlspecialchars($doctorName) . '</p>
            <p><strong>Tratamiento:</strong> ' . htmlspecialchars($treatmentName) . '</p>
            <p><strong>Fecha:</strong> ' . $invoice->getIssuedAt()->format('d/m/Y') . '</p>
        </div>

        <table>
            <tr>
                <th>Concepto</th>
                <th>Importe</th>
            </tr>
            <tr>
                <td>Precio base</td>
                <td>€ ' . number_format($invoice->getBaseAmount(), 2, ',', '.') . '</td>
            </tr>
            <tr>
                <td>IVA (' . $invoice->getTaxRate() . '%)</td>
                <td>€ ' . number_format($invoice->getTaxAmount(), 2, ',', '.') . '</td>
            </tr>
            <tr class="total-row">
                <td>Total</td>
                <td>€ ' . number_format($invoice->getTotalAmount(), 2, ',', '.') . '</td>
            </tr>
        </table>

        <div class="footer">
            Gracias por su confianza.
        </div>
    </body>
    </html>
    ';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return $dompdf->output();
}



    }
        


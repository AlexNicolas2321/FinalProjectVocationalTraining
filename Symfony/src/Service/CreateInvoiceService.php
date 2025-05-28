<?php

    namespace App\Service;
    
    use App\Entity\Appointment;
    use App\Entity\Invoice;
    use Doctrine\ORM\EntityManagerInterface;
    use Dompdf\Dompdf;
    use Dompdf\Options;

    
    class CreateInvoiceService
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
            $invoice->setStatus("pending");
    
            // Calculate the amounts
            $basePrice = $invoice->getBaseAmount();
            $taxAmount = $basePrice * ($invoice->getTaxRate() / 100);
            $totalAmount = $basePrice + $taxAmount;
    
            $invoice->setTaxAmount($taxAmount);
            $invoice->setTotalAmount($totalAmount);
    
            
            $this->entityManager->persist($invoice);
            $this->entityManager->flush();
    
            $patientName = $patient->getFirstName() . ' ' . $patient->getLastName();
            
            // 5️⃣ Update with the PDF path
            $this->entityManager->flush();

            $pdfBinaryContent = $this->generatePdf($invoice, $patientName);
            $invoice->setPdfFile($pdfBinaryContent);

            return $invoice;
        }
    
        private function generatePdf(Invoice $invoice, string $patientName): string
        {
            // Configure Dompdf options
            $options = new Options();
            $options->set('defaultFont', 'Arial');
            $dompdf = new Dompdf($options);
    
            
            $html = '
                <h1>Invoice #' . $invoice->getId() . '</h1>
                <p>Patient: ' . $patientName . '</p>
                <p>Base Price: €' . number_format($invoice->getBaseAmount(), 2) . '</p>
                <p>Tax Rate: ' . $invoice->getTaxRate() . '%</p>
                <p>Tax Amount: €' . number_format($invoice->getTaxAmount(), 2) . '</p>
                <p>Total: €' . number_format($invoice->getTotalAmount(), 2) . '</p>
                <p>Date: ' . $invoice->getIssuedAt()->format('Y-m-d') . '</p>
            ';
    
            
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
    
           // Obtiene el contenido del PDF como binario
            $pdfBinaryContent = $dompdf->output();

            return $pdfBinaryContent; // Path to access from the web
        }
    }
        


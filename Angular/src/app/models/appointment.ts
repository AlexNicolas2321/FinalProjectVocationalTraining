export interface Appointment{
    id?: number;
    date: string; // ISO string, ej: "2025-05-21T14:00:00"
    observations?: string;
    patientId: number;
    doctorId: number;
    treatmentId: number;
}
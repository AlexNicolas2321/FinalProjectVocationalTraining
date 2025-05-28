export interface Appointment{
    id?: number;
    date: string; // ISO string, ej: "2025-05-21T14:00:00"
    observations?: string | null;
    userId: number;
    doctorId: number;
    treatmentId?: number;
    created_at?:string;
    patientId?:number;
}
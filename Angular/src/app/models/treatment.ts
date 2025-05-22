
export interface Treatment {
    id?:number,
    name:string,
    description:string,
    price:number,
    doctorId:number | null,
    doctor_first_name?:string,
    doctor_last_name?:string,
    img?:string,

}

export interface User {
    id: number;
    password?:number;
    dni: string;
    user_type?:string;
    first_name?:string;
    last_name?:string;
    roleIds?: number[];   
    roleNames?: string[];
    phone?:number;
    speciality?:string;
  }
  
export interface User {
    id?: number;
    password?:string;
    dni: string;
    user_type?:string;
    first_name?:string;
    last_name?:string;
    roleIds?: number[];   
    roleNames?: string[];
    phone?:string;
    speciality?:string;
    created_at?:string;
  }
  
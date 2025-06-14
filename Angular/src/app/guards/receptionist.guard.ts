import { inject } from '@angular/core';
import { CanActivateFn, CanActivateChildFn, Router } from '@angular/router';
import { jwtDecode } from 'jwt-decode';

export const ReceptionistGuard: CanActivateFn & CanActivateChildFn = () => {
  const router = inject(Router);
  const token = localStorage.getItem('token');

  if (!token) {
    router.navigate(['/unauthorized']);
    return false;
  }

  const decoded: any = jwtDecode(token);
  if (decoded.roles?.includes('ROLE_RECEPTIONIST')) {
    return true;
  }

  router.navigate(['/unauthorized']);
  return false;
};

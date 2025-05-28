import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AppointmenthistoryComponent } from './appointmenthistory.component';

describe('AppointmenthistoryComponent', () => {
  let component: AppointmenthistoryComponent;
  let fixture: ComponentFixture<AppointmenthistoryComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AppointmenthistoryComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AppointmenthistoryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

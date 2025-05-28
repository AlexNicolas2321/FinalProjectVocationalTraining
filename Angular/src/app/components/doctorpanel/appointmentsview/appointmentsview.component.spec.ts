import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AppointmentsviewComponent } from './appointmentsview.component';

describe('AppointmentsviewComponent', () => {
  let component: AppointmentsviewComponent;
  let fixture: ComponentFixture<AppointmentsviewComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AppointmentsviewComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AppointmentsviewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

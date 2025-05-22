import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ShowappointmentsComponent } from './showappointments.component';

describe('ShowappointmentsComponent', () => {
  let component: ShowappointmentsComponent;
  let fixture: ComponentFixture<ShowappointmentsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ShowappointmentsComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ShowappointmentsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

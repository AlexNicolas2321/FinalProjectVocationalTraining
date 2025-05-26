import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifiedappointmentsComponent } from './modifiedappointments.component';

describe('ModifiedappointmentsComponent', () => {
  let component: ModifiedappointmentsComponent;
  let fixture: ComponentFixture<ModifiedappointmentsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ModifiedappointmentsComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ModifiedappointmentsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

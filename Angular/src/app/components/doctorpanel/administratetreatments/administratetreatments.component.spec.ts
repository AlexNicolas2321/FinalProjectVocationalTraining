import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdministratetreatmentsComponent } from './administratetreatments.component';

describe('AdministratetreatmentsComponent', () => {
  let component: AdministratetreatmentsComponent;
  let fixture: ComponentFixture<AdministratetreatmentsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdministratetreatmentsComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AdministratetreatmentsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

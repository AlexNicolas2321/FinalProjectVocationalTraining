import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreatetreatmentComponent } from './createtreatment.component';

describe('CreatetreatmentComponent', () => {
  let component: CreatetreatmentComponent;
  let fixture: ComponentFixture<CreatetreatmentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CreatetreatmentComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CreatetreatmentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

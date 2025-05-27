import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditeuserComponent } from './editeuser.component';

describe('EditeuserComponent', () => {
  let component: EditeuserComponent;
  let fixture: ComponentFixture<EditeuserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EditeuserComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EditeuserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

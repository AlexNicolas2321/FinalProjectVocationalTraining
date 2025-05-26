import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SidebarReceptionistComponent } from './sidebar-receptionist.component';

describe('SidebarReceptionistComponent', () => {
  let component: SidebarReceptionistComponent;
  let fixture: ComponentFixture<SidebarReceptionistComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SidebarReceptionistComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SidebarReceptionistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

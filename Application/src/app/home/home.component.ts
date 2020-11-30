import { Component, OnInit } from '@angular/core';
import { Product } from '../_models';
import { ProductService } from '../_services';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  products: Product[];
  onlyAvailable: boolean = true;
  displayedColumns: string[] = ["id", "name", "stock", "action"];
  constructor( private prodcutService: ProductService) { }

  ngOnInit() {
    this.loadAllProducts();
  }

  private loadAllProducts() {
    if(this.products)
      this.products.length = 0;
    this.prodcutService.getAll()
    .subscribe(x => {
      this.products = x['products'];
    });
  }

  private loadAllOnStockProducts() {
    this.products.length = 0;
    this.prodcutService.getAllOnStock()
    .subscribe(x => {
      this.products = x['products'];
    });
  }
}

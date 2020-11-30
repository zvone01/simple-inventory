import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Product, Article } from '../_models';
import { ArticleService, ProductService } from '../_services';
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.scss']
})
export class ProductComponent implements OnInit {
  product: Product = new Product();
  articles: Article[];
  numberToSell: number= 1;
  displayedColumns: string[] = ["id", "name", "stock","in_one_product", "action"];

  constructor( private productService: ProductService,
    private articleService: ArticleService,
    private route: ActivatedRoute ) { }

  ngOnInit() {
    this.product.id = parseInt(this.route.snapshot.paramMap.get('id'));
    this.getProduct();
    this.getArticles();
  }

  getProduct() {
    this.productService.readOne(this.product.id)
    .subscribe( x => 
      {this.product.Name = x['name'], this.product.Description =  x['description'], this.product.Stock = x['stock']});
  }

  getArticles() {
    this.articleService.readByProductID(this.product.id)
    .subscribe(x => { this.articles = x['articles']})
  }

  private sellProduct()  {
    console.log(this.product.id);
    this.productService.sell(this.product.id, this.numberToSell)
    .pipe(first())
    .subscribe(

      data => {
        console.log(data["message"]);
        //this.openSnackBar(data["message"])
        this.getArticles();

      },
      error => {
        console.log("Error");
        //this.openSnackBar("Error")

      });
  }
}

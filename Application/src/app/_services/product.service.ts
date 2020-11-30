import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { Product } from '../_models';

@Injectable({
  providedIn: 'root'
})
export class ProductService {

  constructor(private http: HttpClient) { }

  getAll(): Observable<Product[]> {
    return this.http.get<Product[]>(`${environment.apiUrl}/product/read.php`);
  }

  getAllOnStock(): Observable<Product[]> {
    return this.http.get<Product[]>(`${environment.apiUrl}/product/getAvailable.php`);
  }
  create(machine: Product) {
    return this.http.post(`${environment.apiUrl}/machine/create.php`, machine);
  }

  update(machine: Product) {
    return this.http.post(`${environment.apiUrl}/machine/update.php`, machine);
  }

  readOne(ID: number) {
    return this.http.get(`${environment.apiUrl}/product/readOne.php?ID=${ID}`);
  }

  sell(_productId: number, _quantity:number) {
    return this.http.post(`${environment.apiUrl}/product/sell.php`, { id: _productId , quantity: _quantity});
  }

  upload(file: string ) {
    // Make http post request over api
    // with formData as req
    return this.http.post(`${environment.apiUrl}/product/createFromFile.php`,  file );
}
}

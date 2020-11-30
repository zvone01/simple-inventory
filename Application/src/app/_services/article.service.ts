import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { Product } from '../_models';

@Injectable({
  providedIn: 'root'
})
export class ArticleService {

  constructor(private http: HttpClient) { }

  getAll(): Observable<Product[]> {
    return this.http.get<Product[]>(`${environment.apiUrl}/product/getAvailable.php`);
  }

  create(machine: Product) {
    return this.http.post(`${environment.apiUrl}/machine/create.php`, machine);
  }

  update(machine: Product) {
    return this.http.post(`${environment.apiUrl}/machine/update.php`, machine);
  }

  readOne(ID: number) {
    return this.http.get(`${environment.apiUrl}/machine/readOne.php?ID=${ID}`);
  }

  readByProductID(ID: number) {
    return this.http.get(`${environment.apiUrl}/article/readFromProduct.php?ID=${ID}`);
  }
  upload(file: string ) {
    // Make http post request over api
    // with formData as req
    return this.http.post(`${environment.apiUrl}/article/createFromFile.php`,  file );
  }
}

import { Component, OnInit } from '@angular/core';
import { ProductService, ArticleService } from '../_services';

@Component({
    selector: 'app-uploadfile',
    templateUrl: './uploadfile.component.html',
    styleUrls: ['./uploadfile.component.scss']
})
export class UploadfileComponent implements OnInit {

    // Variable to store shortLink from api response
    shortLink: string = "";
    loading: boolean = false; // Flag variable
    file: File = null; // Variable to store file

    // Inject service
    constructor(private productService: ProductService, private articleService: ArticleService) { }

    ngOnInit(): void {
    }

    // On file Select
    onChange(event) {
        this.file = event.target.files[0];
    }

    // OnClick of button Upload
    async onUpload() {
        this.loading = !this.loading;
        
        const fileContent = await this.readFileContent(this.file);
        if (this.file.name === 'products.json'){
          this.productService.upload(fileContent).subscribe(
              (event: any) => {
                console.log(event);
                if (event && event.message) {
                      this.loading = false; // Flag variable
                  }
              }
          );
        } else if (this.file.name === 'inventory.json') {
          this.articleService.upload(fileContent).subscribe(
            (event: any) => {
              console.log(event);
              if (event && event.message) {
                    this.loading = false; // Flag variable
                }
            }
        );
        }
    }

    readFileContent(file: File): Promise<string> {
      return new Promise<string>((resolve, reject) => {
          if (!file) {
              resolve('');
          }

          const reader = new FileReader();

          reader.onload = (e) => {
              const text = reader.result.toString();
              resolve(text);

          };

          reader.readAsText(file);
      });
  }
}
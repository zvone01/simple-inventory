export class Article {
    id: number;
    name: string;
    description: string;
    stock: number;
    in_one_product: number;

    constructor()
    {
        this.id = -1;
        this.stock = -1;
        this.name = "";
        this.description = "";
        this.in_one_product = -1;

    }
}
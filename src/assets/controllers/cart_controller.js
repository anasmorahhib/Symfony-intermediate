import { Controller } from '@hotwired/stimulus';
import axios from 'axios'

export default class extends Controller {
    static targets = ["cartCount"]

    connect() {
        this.itemCount = 0;
    }

    addToCart(event) {
        event.preventDefault()
        const productUrl = event.target.dataset.productUrl;
        const oldText = event.target.innerText
        event.target.innerText = "Loading..."
        // call Api befor
        axios.post(productUrl)
            .then(response => {
                this.itemCount++;
                this.cartCountTarget.innerText = this.itemCount || 0;
                console.log(`Produit, ${this.itemCount} ajouté au panier!`);
            })
            .catch(error => {
                console.error('Erreur lors de l\'ajout au panier :', error);
            }).finally(() => {
                event.target.innerText = oldText
            })

    }
}
<?php

namespace App\Http\Livewire;

use App\Facades\Cart;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class BookComponent extends Component
{
    public $book;
    public $quantity;
    /**
     * Mounts the component on the template.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->quantity = 1;
    }
    /**
     * Renders the component on the browser.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view('livewire.book');
    }
    /**
     * Adds an item to cart.
     *
     * @return void
     */
    public function addToCart(): void
    {
        if ($this->book->in_stock) {
            Cart::add($this->book->id, $this->book->title, $this->book->getRawOriginal('price'), $this->quantity);
            $this->emit('productAddedToCart');
        }
    }
}

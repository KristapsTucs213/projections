<x-layout>
    <x-slot:title>
        All products
    </x-slot>

    <ul class="product-list">
        @foreach ($products as $product)
            <li>
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>
                <div class="product-actions">
                    <a href="{{ route('products.show', [$product]) }}" class="btn btn-show">Show</a>
                    <a href="{{ route('products.edit', [$product]) }}" class="btn btn-edit">Edit</a>
                    <form action="{{ route('products.destroy', [$product]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="destroy" class="btn btn-delete">
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

</x-layout>

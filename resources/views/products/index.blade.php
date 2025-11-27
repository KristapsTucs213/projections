<x-layout>
    <x-slot:title>
        All products
    </x-slot>

    <ul class="product-list">
        @foreach ($products as $product)
            <li>
                <h1>{{ $product->name }}</h1>

                {{-- Show tags here --}}
                @if ($product->tags->count())
                    <div class="product-tags">
                        <strong>Tags:</strong>
                        @foreach ($product->tags as $tag)
                            <span class="tag">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif

                <p>{{ $product->description }}</p>

                <div class="product-actions">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-show">Show</a>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-edit">Edit</a>

                    <form action="{{ route('products.destroy', $product) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="destroy" class="btn btn-delete">
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

</x-layout>

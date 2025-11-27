<x-layout>
    <x-slot:title>
        Show a product
    </x-slot>

    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1>{{ $product->name }}</h1>



    <form action="{{ route('products.up', $product) }}" method="post">
        @csrf
        @method('patch')
        <input type="number" name="amount" value="+">
        <input type="submit" value="done">
    </form>

    
    <h4>Quantity: {{ $product->quantity }}</h4>

    <form action="{{ route('products.down', $product) }}" method="post">
        @csrf
        @method('patch')
        <input type="number" name="amount" value="-">
        <input type="submit" value="done">
    </form>





    <p>{{ $product->description }}</p>

    <a href="{{ route('products.edit', [$product]) }}">Edit</a>
    <form action="{{ route('products.destroy', $product) }}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete">
    </form>
</x-layout>
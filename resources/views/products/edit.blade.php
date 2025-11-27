<x-layout>
    <x-slot:title>
        Edit product
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

    <form action="{{ route('products.update', [$product]) }}" method="post">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $product->name }}">
        <input type="number" name="quantity" value="{{ $product->quantity }}">
        <textarea name="description">{{ $product->description }}</textarea>
        <input type="submit" value="Submit">
    </form>
</x-layout>

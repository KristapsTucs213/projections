<x-layout>
    <x-slot:title>
        Create new product
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

    <form action="{{ route('products.store') }}" method="post">
        @csrf
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Product name">
        <input type="number" name="quantity" value="{{ old('quantity') }}" placeholder="Quantity">
        <input type="text" name="description" value="{{ old('description') }}" placeholder="description">
        <!-- <textarea name="content" placeholder="Product description">{{ old('description') }}</textarea> -->
        <input type="submit" value="Submit">
    </form>
</x-layout>

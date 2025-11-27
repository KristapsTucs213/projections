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

    <h3>Tags:</h3>
    <ul>
        @foreach ($product->tags as $tag)
            <li>{{ $tag->name }}</li>
        @endforeach
    </ul>



    <!-- <form action="{{ route('products.up', $product) }}" method="post">
        @csrf
        @method('patch')
        <input type="number" name="amount" value="+">
        <input type="submit" value="done">
    </form> -->


    <h4 id="quantity">Quantity: {{ $product->quantity }}</h4>


    <!-- <form action="{{ route('products.down', $product) }}" method="post">
        @csrf
        @method('patch')
        <input type="number" name="amount" value="-">
        <input type="submit" value="done">
    </form> -->

     
    <input type="number" id="increaseAmount" min="1">
    <button id="increaseBtn">Increase</button>

    <input type="number" id="decreaseAmount" min="1">
    <button id="decreaseBtn">Decrease</button>



    <p>{{ $product->description }}</p>

    <a href="{{ route('products.edit', [$product]) }}">Edit</a>
    <form action="{{ route('products.destroy', $product) }}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete">
    </form>
    
    <div id="error" style="color: red; margin-top: 10px;"></div>

    <script>
        const increaseBtn = document.getElementById('increaseBtn');
        const decreaseBtn = document.getElementById('decreaseBtn');
        const quantitySpan = document.getElementById('quantity');
        const errorDiv = document.getElementById('error');

        async function sendUpdate(url, amount) {
            errorDiv.textContent = ""; 

            let res = await fetch(url, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ amount })
            });

            let data = await res.json();

            if (res.ok) {
                quantitySpan.textContent = data.quantity;
            } else {
                if (data.errors?.amount) {
                    errorDiv.textContent = data.errors.amount[0];
                } else {
                    errorDiv.textContent = "An error occurred.";
                }
            }
        }

        increaseBtn.addEventListener("click", () => {
            const amount = parseInt(document.getElementById('increaseAmount').value);
            sendUpdate("{{ route('products.up', $product) }}", amount);
        });

        decreaseBtn.addEventListener("click", () => {
            const amount = parseInt(document.getElementById('decreaseAmount').value);
            sendUpdate("{{ route('products.down', $product) }}", amount);
        });
    </script>

</x-layout>

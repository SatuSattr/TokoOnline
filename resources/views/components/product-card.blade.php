@props(['product'])

<div class="relative flex w-full max-w-xs max-h-[434px] flex-col overflow-hidden rounded-lg border border-gray-800 bg-[#212121] shadow-md hover:border-accent transition group cursor-pointer"
    onclick="window.location.href = `/products/{{ $product->id }}`">
    <a class="relative mx-3 mt-3 flex min-h-60 overflow-hidden rounded-xl" href="#">
        @if ($product->image)
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="object-cover w-full h-full"
                onerror="this.src='{{ asset('img/hero.jpg') }}'; this.onerror=null;" />
        @else
            <img src="{{ asset('img/hero.jpg') }}" alt="{{ $product->name }}" class="object-cover w-full h-full" />
        @endif
        @if ($product->disc_price > 0 && $product->disc_price < $product->price)
            <span
                class="absolute top-0 left-0 m-2 rounded-lg bg-red-500 px-2 text-center text-sm font-medium text-white">
                -{{ round((($product->price - $product->disc_price) / $product->price) * 100) }}%
            </span>
        @endif
    </a>
    <div class="mt-4 px-5 pb-5 flex flex-col  justify-between h-full">
        <a href="#">
            <h5 class="text-lg tracking-tight text-primary" title="{{ $product->name }}">
                {{ Str::limit($product->name, 30) }}
            </h5>
        </a>
        <div class="mt-2 mb-5 flex justify-between">
            <p>
                @if ($product->disc_price > 0 && $product->disc_price < $product->price)
                    <span class="text-lg font-bold text-red-500">
                        {{ $product->getFormattedDiscPriceAttribute() }}
                    </span>
                    <span class="text-base text-secondary line-through">
                        {{ $product->getFormattedPriceAttribute() }}
                    </span>
                @else
                    <span class="text-lg font-bold text-primary">
                        {{ $product->getFormattedPriceAttribute() }}
                    </span>
                @endif
            </p>
            <div class="flex items-center">
                @php
                    $fullStars = floor($product->rating);
                    $hasHalfStar = $product->rating - $fullStars >= 0.5;
                    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);

                    for ($i = 0; $i < $fullStars; $i++) {
                        echo '<i class="fas fa-star text-yellow-500"></i>';
                    }

                    if ($hasHalfStar) {
                        echo '<i class="fas fa-star-half-alt text-yellow-500"></i>';
                    }

                    for ($i = 0; $i < $emptyStars; $i++) {
                        echo '<i class="far fa-star text-yellow-500"></i>';
                    }
                @endphp
                <span class="rounded text-sm ml-1 text-yellow-500">
                    ({{ number_format($product->rating, 1) }})
                </span>
            </div>
        </div>
        <a href="#"
            class="flex items-center justify-center rounded-md bg-primary text-dark px-5 py-2 text-center text-sm font-medium hover:bg-gray-200 transition"
            onclick="event.stopPropagation(); addToCart({{ $product->id }});">
            <i class="fas fa-shopping-cart mr-2"></i>
            Add to cart
        </a>
    </div>
</div>

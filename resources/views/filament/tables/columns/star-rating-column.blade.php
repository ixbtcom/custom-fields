@php
    $state = $getDisplayValue();
    $stars = $getStarCount();
    $max = $getMaxValue();
    $pointsPerStar = $getPointsPerStar();
    $placeholder = $getPlaceholder() ?: '—';
    $fillWidth = function (int $index) use ($state, $pointsPerStar): float {
        if ($state === null) {
            return 0.0;
        }

        $starStart = ($index - 1) * $pointsPerStar;
        $starEnd = $index * $pointsPerStar;

        if ($state <= $starStart) {
            return 0.0;
        }

        if ($state >= $starEnd) {
            return 100.0;
        }

        return (($state - $starStart) / $pointsPerStar) * 100;
    };
@endphp

<div class="cf-star-rating cf-star-rating--column">
    @if ($state === null)
        <span class="cf-star-rating__value cf-star-rating__value--placeholder">{{ $placeholder }}</span>
    @else
        <div class="cf-star-rating__stars cf-star-rating__stars--sm" role="img" aria-label="{{ number_format($state, 1) }} / {{ number_format($max, 0) }}">
            @for ($i = 1; $i <= $stars; $i++)
                <span class="cf-star-rating__star cf-star-rating__star--sm">
                    <svg class="cf-star-rating__star-bg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2.5l2.95 6.6 7.05.8-5.25 4.95 1.55 7.15-6.3-3.6-6.3 3.6 1.55-7.15L2 9.9l7.05-.8L12 2.5z" />
                    </svg>
                    <span class="cf-star-rating__star-fill" style="width: {{ $fillWidth($i) }}%">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2.5l2.95 6.6 7.05.8-5.25 4.95 1.55 7.15-6.3-3.6-6.3 3.6 1.55-7.15L2 9.9l7.05-.8L12 2.5z" />
                        </svg>
                    </span>
                </span>
            @endfor
        </div>
        <span class="cf-star-rating__value cf-star-rating__value--sm">{{ rtrim(rtrim(number_format($state, 1, '.', ''), '0'), '.') }}</span>
    @endif
</div>

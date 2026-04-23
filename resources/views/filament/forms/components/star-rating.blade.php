@php
    $statePath = $getStatePath();
    $maxValue = $getMaxValue();
    $step = $getStep();
    $stars = $getStarCount();
    $pointsPerStar = $getPointsPerStar();
    $clearable = $isClearable();
    $disabled = $isDisabled();
    $readOnly = $isReadOnly();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{
            state: $wire.$entangle(@js($statePath)),
            max: @js($maxValue),
            step: @js($step),
            stars: @js($stars),
            pointsPerStar: @js($pointsPerStar),
            clearable: @js($clearable),
            disabled: @js($disabled),
            readOnly: @js($readOnly),

            snap(value) {
                if (value === null || value === '' || value === undefined) {
                    return null;
                }

                const float = parseFloat(value);

                if (Number.isNaN(float)) {
                    return null;
                }

                let bounded = Math.max(0, Math.min(this.max, float));

                if (this.step > 0) {
                    bounded = Math.round(bounded / this.step) * this.step;
                }

                return Math.round(bounded * 1000) / 1000;
            },

            setFromStar(index, isHalf) {
                if (this.disabled || this.readOnly) return;

                const portion = isHalf ? 0.5 : 1.0;
                const next = this.snap((index - 1 + portion) * this.pointsPerStar);

                this.state = (this.clearable && next === this.state) ? null : next;
            },

            clear() {
                if (this.disabled || this.readOnly) return;
                this.state = null;
            },

            onNumberInput(event) {
                const raw = event.target.value;
                this.state = raw === '' ? null : parseFloat(raw);
            },

            onNumberBlur(event) {
                this.state = this.snap(event.target.value);
            },

            fillWidth(index) {
                if (this.state === null || this.state === undefined) return 0;

                const starStart = (index - 1) * this.pointsPerStar;
                const starEnd = index * this.pointsPerStar;

                if (this.state <= starStart) return 0;
                if (this.state >= starEnd) return 100;

                return ((this.state - starStart) / this.pointsPerStar) * 100;
            }
        }"
        class="cf-star-rating"
    >
        <div
            class="cf-star-rating__stars"
            role="radiogroup"
            :aria-disabled="disabled || readOnly ? 'true' : 'false'"
        >
            <template x-for="i in stars" :key="i">
                <span
                    class="cf-star-rating__star"
                    :class="{ 'cf-star-rating__star--interactive': !disabled && !readOnly }"
                >
                    <svg
                        class="cf-star-rating__star-bg"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        aria-hidden="true"
                    >
                        <path d="M12 2.5l2.95 6.6 7.05.8-5.25 4.95 1.55 7.15-6.3-3.6-6.3 3.6 1.55-7.15L2 9.9l7.05-.8L12 2.5z" />
                    </svg>
                    <span
                        class="cf-star-rating__star-fill"
                        :style="`width: ${fillWidth(i)}%`"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path d="M12 2.5l2.95 6.6 7.05.8-5.25 4.95 1.55 7.15-6.3-3.6-6.3 3.6 1.55-7.15L2 9.9l7.05-.8L12 2.5z" />
                        </svg>
                    </span>
                    <button
                        type="button"
                        class="cf-star-rating__star-hit cf-star-rating__star-hit--left"
                        @click.prevent="setFromStar(i, true)"
                        :disabled="disabled || readOnly"
                        :aria-label="`Set rating to ${((i - 1 + 0.5) * pointsPerStar).toFixed(1)}`"
                        tabindex="-1"
                    ></button>
                    <button
                        type="button"
                        class="cf-star-rating__star-hit cf-star-rating__star-hit--right"
                        @click.prevent="setFromStar(i, false)"
                        :disabled="disabled || readOnly"
                        :aria-label="`Set rating to ${(i * pointsPerStar).toFixed(1)}`"
                        tabindex="-1"
                    ></button>
                </span>
            </template>
        </div>

        <input
            type="number"
            :min="0"
            :max="max"
            :step="step"
            :value="state === null || state === undefined ? '' : state"
            :disabled="disabled"
            :readonly="readOnly"
            @input.stop="onNumberInput($event)"
            @blur="onNumberBlur($event)"
            class="cf-star-rating__input fi-input block w-20 rounded-lg border-none bg-white/0 px-3 py-1.5 text-base text-gray-950 outline-none transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6"
        />

        <span class="cf-star-rating__max" aria-hidden="true">/ <span x-text="max"></span></span>

        <template x-if="clearable && !disabled && !readOnly && state !== null && state !== undefined">
            <button
                type="button"
                class="cf-star-rating__clear"
                @click.prevent="clear()"
                aria-label="Clear rating"
            >
                &times;
            </button>
        </template>
    </div>
</x-dynamic-component>

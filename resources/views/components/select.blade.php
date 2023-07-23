@props(['options' => []])

<select {{$attributes->merge(['class' =>
        'rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6']) }}>
    @foreach ($options as $option)
        <option value="{{ $option['id'] }}">{{ Str::ucfirst($option['name']) }}</option>
    @endforeach
</select>

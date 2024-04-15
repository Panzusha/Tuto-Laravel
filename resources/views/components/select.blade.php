{{-- (voir vidéo 24 formulaire inscription) / Input.php --}}
<div>
    <label for="{{ $id }}" class="block text-sm font-medium leading-6 text-gray-900">{{ $label }}</label>
    {{-- on regarde dans les erreurs s'il y en qui concernent le champ name --}}
    <div class="mt-2">
        <select
            id="{{ $id }}" 
            {{-- si on est sur du choix multiple on rajoute les [] pour indiquer qu'on vas avoir un tableau --}}
            {{-- si non on ne rajoute rien --}}
            name="{{ $name . ($multiple ? '[]' : '') }}"
            @class([
                // on fait le tri dans les classes tailwindUI entre celles qui concernent les champs état normal et celles des erreurs
                'block w-full shadow-sm rounded-md border-0 py-1.5 ring-1 ring-inset 
                focus:ring-2 focus:ring-inset sm:max-w-xs sm:text-sm sm:leading-6',
                'text-red-900 ring-red-300 focus:ring-red-500' 
                => $errors->has($name),

                'text-gray-900 ring-gray-300 focus:ring-indigo-600' 
                => ! $errors->has($name),

                // si on est pas sur un choix multiple
                'form-select' => ! $multiple,
                // si on est sur un choix multiple
                'form-multiselect' => $multiple,
            ])
            {{-- si la propriété booléenne $multiple existe (true) on insère l'élément, on met l'attribut multiple dans l'élément html --}}
            @if ($multiple) multiple @endif
        >
        @foreach ($list as $item)
        <option 
            {{-- valeur cachée ID --}}
            value="{{ $item->$optionsValues }}"
            {{-- on test si on est sur une collection, si oui on cherche dans la collection un élément correspondant à celui qu'on est entrain d'itérer pour qu'il soit pré selectionné --}}
            {{-- si on est sur une valeur simple, on vérifie que son id (valuekeys) correspond a $value --}}
            @selected($valueIsCollection ? $value->contains($item->$optionsValues) : 
            $item->$optionsValues == $value)
        >
            {{-- valeur correspondante affichée texte --}}
            {{ $item->$optionsTexts }}
        </option>
        @endforeach
        </select>
    </div>

    @error($name)
    <p class="mt-2 text-sm text-red-600">{{ $message  }}</p>
    @enderror

    @if ($help)
    <p class="mt-2 text-sm text-gray-500">{{ $help }}</p>
    @endif
</div>
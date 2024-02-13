<tr>
    <th scope="row">
        @if($ajuste_contador == 1)
            <span class="btn btn-default btn-xs disabled">
                <i class="fas fa-minus"></i>
            </span>
        @else
            <span wire:click="btnContador('{{ $i }}')" class="btn btn-default btn-xs">
                <i class="fas fa-minus"></i>
            </span>
        @endif
        <span class="">{{ $i + 1 }}</span>
    </th>
    <td>
        <input type="text" class="form-control form-control-sm {{ $classTipo[$i] }}
        @error('ajusteTipo.'.$i) is-invalid @enderror" wire:model.blur="ajusteTipo.{{ $i }}" placeholder="código">
    </td>
    <td>
        <input type="text" class="form-control form-control-sm {{ $classArticulo[$i] }}
        @error('ajusteArticulo.'.$i) is-invalid @enderror" wire:model.blur="ajusteArticulo.{{ $i }}"
               data-toggle="tooltip" data-placement="bottom" title="{{ $ajusteArticulo[$i] }}" placeholder="código">
    </td>
    <td>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend" wire:click="itemTemporalAjuste({{ $i }})"
                 data-toggle="modal" data-target="#modal-buscar-articulo" style="cursor: pointer">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control form-control-sm"
                   data-toggle="tooltip" data-placement="bottom" title="{{ $ajusteDescripcion[$i] }}"
                   wire:model.live="ajusteDescripcion.{{ $i }}" placeholder="Descripción"
                   readonly>
        </div>
    </td>
    <td>
        <input type="text" class="form-control form-control-sm {{ $classAlmacen[$i] }} @error('ajusteAlmacen.'.$i) is-invalid @enderror"
               wire:model.blur="ajusteAlmacen.{{ $i }}" placeholder="código">
    </td>
    <td>
        <select class="form-control form-control-sm
        @error('ajusteUnidad.'.$i) is-invalid @enderror" wire:model.live="ajusteUnidad.{{ $i }}">
            @foreach($selectUnidad[$i] as $unidad)
                <option value="{{ $unidad['id'] }}">{{ $unidad['codigo'] }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="number" class="form-control form-control-sm
        @error('ajusteCantidad.'.$i) is-invalid @enderror" min="0.001" step=".001"
               wire:model.live="ajusteCantidad.{{ $i }}">
    </td>
</tr>
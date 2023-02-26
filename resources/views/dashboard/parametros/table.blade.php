<div class="table-responsive" xmlns:wire="http://www.w3.org/1999/xhtml">
    <table class="table table-hover bg-light">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">id</th>
            <th scope="col">nombre</th>
            <th scope="col">table_id</th>
            <th scope="col">valor</th>
            <th scope="col" style="width: 5%;">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        {{-- @if(!$parametros->isEmpty())
             @foreach($parametros as $parametro)
                 <th scope="row" class="text-center">{{ $parametro->id }}</th>
                 <td>{{ $parametro->nombre }}</td>
                 <td>@if(is_null($parametro->tabla_id)) <em>null</em> @else {{ $parametro->tabla_id }} @endif</td>
                 <td>
                     @if(is_null($parametro->valor))
                         null
                     @else
                         @if($parametro->tabla_id == "-1")
                             json{...}
                         @else
                             {{ $parametro->valor }}
                         @endif
                     @endif
                 </td>
                 <td class="justify-content-end">
                     <div class="btn-group">
                         <button wire:click="edit({{ $parametro->id }})"  class="btn btn-info btn-sm">
                             <i class="fas fa-edit"></i>
                         </button>

                         <button wire:click="destroy({{ $parametro->id }})" class="btn btn-info btn-sm">
                             <i class="fas fa-trash-alt"></i>
                         </button>
                     </div>
                 </td>
                 </tr>
             @endforeach
         @else
             <tr class="text-center">
                 <td colspan="5">
                     <a href="{{ route('parametros.index') }}">
                             <span>
                                 Sin resultados para la busqueda <strong class="text-bold"> { <span class="text-danger">{{ $busqueda }}</span> }</strong>
                             </span>
                     </a>
                 </td>
             </tr>
         @endif--}}
        <th scope="row" class="text-center">1</th>
        <td>2</td>
        <td>2</td>
        <td>2</td>
        <td class="justify-content-end">
            <div class="btn-group">
                <button {{--wire:click="edit({{ $parametro->id }})"--}} class="btn btn-info btn-sm">
                    <i class="fas fa-edit"></i>
                </button>

                <button {{--wire:click="destroy({{ $parametro->id }})"--}} class="btn btn-info btn-sm">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </td>
        </tbody>
    </table>
</div>

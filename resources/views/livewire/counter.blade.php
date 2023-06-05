<div xmlns:wire="http://www.w3.org/1999/xhtml">
    {{-- Do your work, then step back. --}}
    <h1>Hello World!</h1>
    <div style="text-align: center">

        <h1>{{ $count }}</h1>

    </div>

    <div class="form-group" wire:ignore>
        <label> Select2 Multiple</label>
        <select class="form-control select2" multiple="multiple"
                data-placeholder="Seleccione..." id="comercial_lista_calc">
            <option value="1">Alabama</option>
            <option value="2">Alaska</option>
            <option value="3">California</option>
            <option value="10">Delaware</option>
            <option value="11">Tennessee</option>
            <option value="12">Texas</option>
            <option value="13">Washington</option>
        </select>
    </div>
    <br>
    <p>{!! $select !!}</p>

</div>

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $equipo->nombre ?? '') }}"
           class="form-control @error('nombre') is-invalid @enderror">
    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Ubicación</label>
    <input type="text" name="ubicacion" value="{{ old('ubicacion', $equipo->ubicacion ?? '') }}"
           class="form-control @error('ubicacion') is-invalid @enderror">
    @error('ubicacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" rows="3"
              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $equipo->descripcion ?? '') }}</textarea>
    @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Estado</label>
    <select name="estado" class="form-select @error('estado') is-invalid @enderror">
        @foreach (\App\Models\Equipo::ESTADOS as $valor => $texto)
            <option value="{{ $valor }}" @selected(old('estado', $equipo->estado ?? 'operativo') === $valor)>
                {{ $texto }}
            </option>
        @endforeach
    </select>
    @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
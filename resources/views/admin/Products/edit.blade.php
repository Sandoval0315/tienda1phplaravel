@extends('layouts.admin')

@section('title', 'Editar Producto')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-6">

        {{-- Header --}}
        <div class="mb-10">
            <p class="text-xs tracking-[0.2em] text-gray-400 uppercase mb-2">Administración / Productos</p>
            <h1 class="text-3xl font-light tracking-wide">Editar Producto</h1>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Bloque 1: Identidad --}}
            <div class="bg-white border border-gray-100 rounded-xl p-8 space-y-6">
                <p class="text-xs tracking-[0.15em] text-gray-400 uppercase">Identidad</p>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Nombre *</label>
                        <input type="text" name="name" value="{{ $product->name }}"
                            class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none transition-colors" required>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Marca *</label>
                            <input type="text" name="brand" value="{{ $product->brand }}"
                                class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none transition-colors" required>
                        </div>
                        <div>
                            <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Categoría *</label>
                            <select name="category" id="category"
                                class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none appearance-none cursor-pointer transition-colors" required>
                                @foreach(['Camisetas','Pantalones','Vestidos','Chaquetas','Zapatos','Carteras','Gorras'] as $cat)
                                <option value="{{ $cat }}" {{ $product->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Descripción *</label>
                        <textarea name="description" rows="3"
                            class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none resize-none transition-colors" required>{{ $product->description }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Bloque 2: Precio y stock --}}
            <div class="bg-white border border-gray-100 rounded-xl p-8 space-y-6">
                <p class="text-xs tracking-[0.15em] text-gray-400 uppercase">Precio & Stock</p>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Precio *</label>
                        <div class="flex items-center border-b border-gray-200 focus-within:border-black transition-colors">
                            <span class="text-gray-400 text-sm mr-2">$</span>
                            <input type="number" name="price" step="0.01" value="{{ $product->price }}"
                                class="flex-1 bg-transparent py-2 text-sm outline-none" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Stock *</label>
                        <input type="number" name="stock" value="{{ $product->stock }}"
                            class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none transition-colors" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">URL de imagen</label>
                    <input type="url" name="image" value="{{ $product->image }}"
                        class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none transition-colors"
                        placeholder="https://...">
                </div>
            </div>

            {{-- Bloque 3: Tallas --}}
            <div class="bg-white border border-gray-100 rounded-xl p-8 space-y-4" id="sizes-section" style="display:none">
                <p class="text-xs tracking-[0.15em] text-gray-400 uppercase" id="sizes-label">Tallas</p>
                <div id="sizes-options" class="flex flex-wrap gap-2"></div>
            </div>

            {{-- Bloque 4: Colores --}}
            <div class="bg-white border border-gray-100 rounded-xl p-8 space-y-6">
                <p class="text-xs tracking-[0.15em] text-gray-400 uppercase">Colores</p>

                <div>
                    <p class="text-xs text-gray-400 mb-3">Colores comunes</p>
                    <div class="flex flex-wrap gap-2" id="preset-colors">
                        @foreach(['Negro','Blanco','Rojo','Azul','Verde','Amarillo','Rosa','Morado','Naranja','Gris','Café','Beige'] as $c)
                        <button type="button"
                            data-color="{{ $c }}"
                            class="color-preset-btn px-4 py-1.5 text-xs tracking-wider border border-gray-200 rounded-full hover:border-black transition-colors">
                            {{ $c }}
                        </button>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-3 items-center border-b border-gray-200 focus-within:border-black transition-colors pb-1">
                    <input type="text" id="custom-color"
                        class="flex-1 bg-transparent py-1.5 text-sm outline-none"
                        placeholder="Color personalizado (Ej: Turquesa, Lavanda...)">
                    <button type="button" id="add-color-btn"
                        class="text-xs tracking-widest text-gray-500 hover:text-black uppercase transition-colors whitespace-nowrap">
                        + Agregar
                    </button>
                </div>

                <div>
                    <p class="text-xs text-gray-400 mb-2">Seleccionados</p>
                    <div id="selected-colors" class="flex flex-wrap gap-2 min-h-[32px]">
                        <span class="text-xs text-gray-300 italic" id="empty-msg">Ningún color seleccionado</span>
                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="text-sm text-gray-400 hover:text-black tracking-wider transition-colors">
                    ← Cancelar
                </a>
                <button type="submit"
                    class="bg-black text-white text-xs tracking-[0.2em] uppercase px-8 py-3 rounded-full hover:bg-gray-800 transition-colors">
                    Actualizar Producto
                </button>
            </div>

        </form>
    </div>
</div>

<script>
const sizeOptions = {
    'Camisetas': { label: 'Tallas — Camisetas', options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] },
    'Pantalones': { label: 'Tallas — Pantalones', options: ['26', '28', '30', '32', '34', '36', '38', '40', '42', '44'] },
    'Vestidos': { label: 'Tallas — Vestidos', options: ['XS', 'S', 'M', 'L', 'XL'] },
    'Chaquetas': { label: 'Tallas — Chaquetas', options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] },
    'Zapatos': { label: 'Tallas — Zapatos (EU)', options: ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'] },
    'Carteras': { label: 'Tamaños — Carteras', options: ['Mini', 'Pequeña', 'Mediana', 'Grande', 'Extra Grande'] },
    'Gorras': { label: 'Tallas — Gorras', options: ['S', 'M', 'L', 'XL', 'Ajustable'] }
};

const currentSizes = @json(json_decode($product->sizes) ?? []);
const currentColors = @json(json_decode($product->colors) ?? []);
let selectedColors = [...currentColors];

function updateSizeOptions() {
    const category = document.getElementById('category').value;
    const section = document.getElementById('sizes-section');
    const optionsDiv = document.getElementById('sizes-options');
    const label = document.getElementById('sizes-label');

    if (category && sizeOptions[category]) {
        section.style.display = 'block';
        label.textContent = sizeOptions[category].label;
        optionsDiv.innerHTML = '';
        sizeOptions[category].options.forEach(opt => {
            const isChecked = currentSizes.includes(opt);
            const lbl = document.createElement('label');
            lbl.className = 'size-label cursor-pointer';
            lbl.innerHTML = `
                <input type="checkbox" name="sizes[]" value="${opt}" class="hidden size-check" ${isChecked ? 'checked' : ''}>
                <span class="size-tag inline-block px-4 py-1.5 text-xs tracking-wider border rounded-full transition-colors
                    ${isChecked ? 'bg-black text-white border-black' : 'border-gray-200 hover:border-black'}">${opt}</span>
            `;
            lbl.querySelector('input').addEventListener('change', function() {
                lbl.querySelector('.size-tag').classList.toggle('bg-black', this.checked);
                lbl.querySelector('.size-tag').classList.toggle('text-white', this.checked);
                lbl.querySelector('.size-tag').classList.toggle('border-black', this.checked);
                lbl.querySelector('.size-tag').classList.toggle('border-gray-200', !this.checked);
            });
            optionsDiv.appendChild(lbl);
        });
    } else {
        section.style.display = 'none';
    }
}

function renderSelectedColors() {
    const container = document.getElementById('selected-colors');
    const emptyMsg = document.getElementById('empty-msg');
    container.querySelectorAll('.color-tag').forEach(el => el.remove());

    if (selectedColors.length === 0) {
        emptyMsg.style.display = '';
    } else {
        emptyMsg.style.display = 'none';
        selectedColors.forEach(color => {
            const tag = document.createElement('div');
            tag.className = 'color-tag flex items-center gap-2 px-4 py-1.5 bg-black text-white text-xs tracking-wider rounded-full';
            tag.innerHTML = `
                <span>${color}</span>
                <button type="button" onclick="removeColor('${color}')" class="opacity-60 hover:opacity-100 leading-none">✕</button>
                <input type="hidden" name="colors[]" value="${color}">
            `;
            container.appendChild(tag);
        });
    }
}

function addColor(color) {
    color = color.trim();
    if (color && !selectedColors.includes(color)) {
        selectedColors.push(color);
        renderSelectedColors();
    }
}

function removeColor(color) {
    selectedColors = selectedColors.filter(c => c !== color);
    renderSelectedColors();
    document.querySelectorAll('.color-preset-btn').forEach(btn => {
        if (btn.dataset.color === color) btn.classList.remove('bg-black', 'text-white', 'border-black');
    });
}

document.querySelectorAll('.color-preset-btn').forEach(btn => {
    // Marcar activos con colores ya guardados
    if (currentColors.includes(btn.dataset.color)) {
        btn.classList.add('bg-black', 'text-white', 'border-black');
    }
    btn.addEventListener('click', function() {
        const color = this.dataset.color;
        if (selectedColors.includes(color)) {
            removeColor(color);
            this.classList.remove('bg-black', 'text-white', 'border-black');
        } else {
            addColor(color);
            this.classList.add('bg-black', 'text-white', 'border-black');
        }
    });
});

document.getElementById('add-color-btn').addEventListener('click', () => {
    const input = document.getElementById('custom-color');
    if (input.value.trim()) { addColor(input.value); input.value = ''; }
});

document.getElementById('custom-color').addEventListener('keypress', e => {
    if (e.key === 'Enter') { e.preventDefault(); document.getElementById('add-color-btn').click(); }
});

document.getElementById('category').addEventListener('change', updateSizeOptions);
updateSizeOptions();
renderSelectedColors();
</script>
@endsection
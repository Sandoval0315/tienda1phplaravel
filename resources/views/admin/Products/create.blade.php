@extends('layouts.admin')

@section('title', 'Crear Producto')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-6">

        {{-- Header --}}
        <div class="mb-10">
            <p class="text-xs tracking-[0.2em] text-gray-400 uppercase mb-2">Administración / Productos</p>
            <h1 class="text-3xl font-light tracking-wide">Nuevo Producto</h1>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-8">
            @csrf

            {{-- Bloque 1: Identidad --}}
            <div class="bg-white border border-gray-100 rounded-xl p-8 space-y-6">
                <p class="text-xs tracking-[0.15em] text-gray-400 uppercase">Identidad</p>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Nombre *</label>
                        <input type="text" name="name"
                            class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none transition-colors"
                            placeholder="Ej. Camiseta lino oversized" required>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Marca *</label>
                            <input type="text" name="brand"
                                class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none transition-colors"
                                placeholder="Ej. BéRRY" required>
                        </div>
                        <div>
                            <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Categoría *</label>
                            <select name="category" id="category"
                                class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none appearance-none cursor-pointer transition-colors" required>
                                <option value="">Seleccionar</option>
                                <option value="Camisetas">Camisetas</option>
                                <option value="Tops y Bodies">Tops y Bodies</option>
                                <option value="Pantalones">Pantalones</option>
                                <option value="Vestidos">Vestidos</option>
                                <option value="Chaquetas">Chaquetas</option>
                                <option value="Sudaderas">Sudaderas</option>
                                <option value="Zapatos">Zapatos</option>
                                <option value="Carteras">Accesorios</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Descripción *</label>
                        <textarea name="description" rows="3"
                            class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none resize-none transition-colors"
                            placeholder="Describe el producto..." required></textarea>
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
                            <input type="number" name="price" step="0.01"
                                class="flex-1 bg-transparent py-2 text-sm outline-none"
                                placeholder="0.00" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">Stock *</label>
                        <input type="number" name="stock"
                            class="w-full border-b border-gray-200 focus:border-black bg-transparent py-2 text-sm outline-none transition-colors"
                            placeholder="0" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs tracking-widest text-gray-500 uppercase mb-2">URL de imagen</label>
                    <input type="url" name="image"
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

                {{-- Colores predefinidos como tags de texto --}}
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

                {{-- Color personalizado --}}
                <div class="flex gap-3 items-center border-b border-gray-200 focus-within:border-black transition-colors pb-1">
                    <input type="text" id="custom-color"
                        class="flex-1 bg-transparent py-1.5 text-sm outline-none"
                        placeholder="Color personalizado (Ej: Turquesa, Lavanda...)">
                    <button type="button" id="add-color-btn"
                        class="text-xs tracking-widest text-gray-500 hover:text-black uppercase transition-colors whitespace-nowrap">
                        + Agregar
                    </button>
                </div>

                {{-- Tags seleccionados --}}
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
                    Guardar Producto
                </button>
            </div>

        </form>
    </div>
</div>

<script>
const sizeOptions = {
    'Camisetas': { label: 'Tallas — Camisetas', options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] },
    'Tops y Bodies': { label: 'Tallas — Tops y Bodies', options: ['XS', 'S', 'M', 'L', 'XL'] },
    'Pantalones': { label: 'Tallas — Pantalones', options: ['26', '28', '30', '32', '34', '36', '38', '40', '42', '44'] },
    'Vestidos': { label: 'Tallas — Vestidos', options: ['XS', 'S', 'M', 'L', 'XL'] },
    'Chaquetas': { label: 'Tallas — Chaquetas', options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] },
    'Zapatos': { label: 'Tallas — Zapatos (EU)', options: ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'] },
    'Accesorios': { label: 'Tallas — Accesorios', options: ['Única'] },
    'Sudaderas': { label: 'Tallas — Sudaderas', options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'] }
};

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
            const btn = document.createElement('label');
            btn.className = 'size-label cursor-pointer';
            btn.innerHTML = `
                <input type="checkbox" name="sizes[]" value="${opt}" class="hidden size-check">
                <span class="size-tag inline-block px-4 py-1.5 text-xs tracking-wider border border-gray-200 rounded-full hover:border-black transition-colors">${opt}</span>
            `;
            btn.querySelector('input').addEventListener('change', function() {
                btn.querySelector('.size-tag').classList.toggle('bg-black', this.checked);
                btn.querySelector('.size-tag').classList.toggle('text-white', this.checked);
                btn.querySelector('.size-tag').classList.toggle('border-black', this.checked);
            });
            optionsDiv.appendChild(btn);
        });
    } else {
        section.style.display = 'none';
    }
}

// ---- Colores ----
let selectedColors = [];

function renderSelectedColors() {
    const container = document.getElementById('selected-colors');
    const emptyMsg = document.getElementById('empty-msg');
    // limpiar solo los tags, no el mensaje vacío
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
        if (btn.dataset.color === color) {
            btn.classList.remove('bg-black', 'text-white', 'border-black');
        }
    });
}

document.querySelectorAll('.color-preset-btn').forEach(btn => {
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
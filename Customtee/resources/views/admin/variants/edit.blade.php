@extends('admin.layout.AdminLayout')

@section('AdminContent')
<style>
    .form-group{
    margin-bottom:15px;
    width: 1400px;
}

#variantsContainer .variant-row{
    padding:10px;
    border:1px dashed #ddd;
    margin-bottom:10px;
    background:#fcfcfc;
}
.variant-header{
    font-size:12px;
    color:#666;
    margin-bottom:6px;
}
.variant-header .col-md-1,
.variant-header .col-md-2,
.variant-header .col-md-3{
    padding-top:2px;
    padding-bottom:2px;
}
.variant-actions{
    margin-top:8px;
}
.variant-image-preview img{
    width:64px;
    height:64px;
    max-width:64px;
    object-fit:cover;
    border-radius:4px;
    border:1px solid #ddd;
}
.variant-image-preview{
    max-height:78px;
    overflow-y:auto;
    overflow-x:hidden;
}

</style>
<div class="d-flex justify-content-between align-items-center" style="margin-bottom:20px;">
    <h3 class="mb-0">Cập nhật biến thể</h3>
    <a href="{{ route('admin.san-pham.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-arrow-left"></i> Danh sách sản phẩm
    </a>
</div>

<form action="{{ route('variants.update', $variant->id) }}" method="POST" enctype="multipart/form-data" style="max-width:1100px;">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <input type="hidden" name="san_pham_id" value="{{ $product->id }}">

    {{-- SẢN PHẨM --}}
    <div class="form-group">
        <label>Sản phẩm</label>
        <select id="productSelect" class="form-control" disabled>
            @foreach($products as $p)
                <option value="{{ $p->id }}"
                        data-img="{{ $p->hinh_anh_chinh ? asset('storage/' . $p->hinh_anh_chinh) : asset('img/shop_01.jpg') }}"
                        data-cat="{{ $p->category->ten_danh_muc ?? '' }}"
                        {{ $product->id == $p->id ? 'selected' : '' }}>
                    {{ $p->ten_san_pham }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">Sửa biến thể sản phẩm.</small>
    </div>

    {{-- PREVIEW SẢN PHẨM --}}
    <div class="product-info-box">
        <img id="previewImg"
             src="{{ $product->hinh_anh_chinh ? asset('storage/' . $product->hinh_anh_chinh) : asset('img/shop_01.jpg') }}">
        <div><b>Danh mục:</b> <span id="productCat">{{ $product->category->ten_danh_muc ?? '-' }}</span></div>
    </div>

    @php
        $colorImages = $product->images->groupBy('mau_sac_id');
        $oldVariants = old('variants');
        if (!$oldVariants) {
            $oldVariants = $product->variants->map(function ($v) use ($colorImages) {
                $images = $v->images->merge($colorImages->get($v->mau_sac_id, collect()))->unique('id');
                return [
                    'id' => $v->id,
                    'mau_sac_id' => $v->mau_sac_id,
                    'kich_thuoc_id' => $v->kich_thuoc_id,
                    'gia' => $v->gia,
                    'gia_khuyen_mai' => $v->gia_khuyen_mai,
                    'so_luong' => $v->so_luong,
                    'trang_thai' => $v->trang_thai ? '1' : '0',
                    'images' => $images->map(fn ($image) => [
                        'id' => $image->id,
                        'url' => asset('storage/' . $image->duong_dan),
                    ])->all(),
                ];
            })->values()->all();
        }
    @endphp

    <div class="form-group">
        <label>Danh sách biến thể</label>
        <div class="border rounded p-3 mb-3">
            <div class="font-weight-bold">Ảnh theo màu</div>
            <small class="text-muted">Mỗi màu chỉ cần upload một lần, ảnh sẽ dùng cho tất cả size của màu đó.</small>
            <div class="row mt-2">
                @foreach($colorImages as $colorId => $images)
                    @php
                        $color = $colors->firstWhere('id', $colorId);
                    @endphp
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold d-block">{{ $color->ten_mau ?? 'Màu' }}</label>
                        <div class="d-flex flex-wrap mb-2">
                            @foreach($images as $image)
                                <div class="position-relative mr-2 mb-2 existing-image" data-image-id="{{ $image->id }}">
                                    <img src="{{ asset('storage/' . $image->duong_dan) }}" alt="Ảnh màu" style="width:64px;height:64px;object-fit:cover;border:1px solid #ddd;border-radius:4px;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute delete-variant-image" style="top:0;right:0;padding:0 4px;" data-image-id="{{ $image->id }}">×</button>
                                </div>
                            @endforeach
                        </div>
                        <input type="file" name="color_images[{{ $colorId }}][]" class="form-control-file color-image-input" accept="image/jpeg,image/png,image/gif,image/webp" multiple>
                        <div class="color-image-preview d-flex flex-wrap mt-2"></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row variant-header">
            <div class="col-md-3">Màu</div>
            <div class="col-md-2">Size</div>
            <div class="col-md-2">Giá</div>
            <div class="col-md-2">Giá KM</div>
            <div class="col-md-2">Số lượng</div>
            <div class="col-md-1">Trạng thái</div>
        </div>
        <div id="variantsContainer">
            @foreach($oldVariants as $index => $row)
                <div class="variant-row" data-index="{{ $index }}">
                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $row['id'] ?? '' }}">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="variants[{{ $index }}][mau_sac_id]" class="form-control form-control-sm" required>
                                <option value="">-- Chọn màu --</option>
                                @foreach($colors as $c)
                                    <option value="{{ $c->id }}" {{ ($row['mau_sac_id'] ?? '') == $c->id ? 'selected' : '' }}>{{ $c->ten_mau }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="variants[{{ $index }}][kich_thuoc_id]" class="form-control form-control-sm" required>
                                <option value="">-- Chọn size --</option>
                                @foreach($sizes as $s)
                                    <option value="{{ $s->id }}" {{ ($row['kich_thuoc_id'] ?? '') == $s->id ? 'selected' : '' }}>{{ $s->ten_kich_thuoc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variants[{{ $index }}][gia]" class="form-control form-control-sm" value="{{ $row['gia'] ?? '' }}" min="0" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variants[{{ $index }}][gia_khuyen_mai]" class="form-control form-control-sm" value="{{ $row['gia_khuyen_mai'] ?? '' }}" min="0">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variants[{{ $index }}][so_luong]" class="form-control form-control-sm" value="{{ $row['so_luong'] ?? '' }}" min="0" required>
                        </div>
                        <div class="col-md-1">
                            <select name="variants[{{ $index }}][trang_thai]" class="form-control form-control-sm">
                                <option value="1" {{ ($row['trang_thai'] ?? '1') == '1' ? 'selected' : '' }}>Hiện</option>
                                <option value="0" {{ ($row['trang_thai'] ?? '1') == '0' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2 text-right">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-variant">Xóa biến thể</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>


<style>
.form-group{
    margin-bottom:15px;
}
.product-info-box{
    margin:15px 0;
    padding:10px;
    border:1px solid #ddd;
    background:#f9f9f9;
}
#previewImg{
    width:120px;
    margin-bottom:10px;
    border-radius:6px;
}
.variant-header{
    font-size:12px;
    color:#000000;
    margin-bottom:6px;
}
.variant-header .col-md-1,
.variant-header .col-md-2,
.variant-header .col-md-3{
    padding-top:2px;
    padding-bottom:2px;
}
#variantsContainer .variant-row{
    padding:10px;
    border:1px dashed #ddd;
    margin-bottom:10px;
    background:#fcfcfc;
    width: 100%;
}
</style>


<script>
const select = document.getElementById('productSelect');
const img = document.getElementById('previewImg');
const cat = document.getElementById('productCat');

function updateInfo() {
    const opt = select.options[select.selectedIndex];
    img.src = opt.dataset.img;
    cat.textContent = opt.dataset.cat;
}

select.addEventListener('change', updateInfo);
updateInfo();

function renderVariantImagePreview(input) {
    const preview = input.closest('.variant-row').querySelector('.variant-image-preview');
    preview.innerHTML = '';
    Array.from(input.files || []).forEach((file, fileIndex) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'position-relative mr-1 mb-1';
        const image = document.createElement('img');
        const remove = document.createElement('button');
        image.src = URL.createObjectURL(file);
        image.onload = () => URL.revokeObjectURL(image.src);
        remove.type = 'button';
        remove.className = 'btn btn-sm btn-danger position-absolute';
        remove.style.cssText = 'top:0;right:0;padding:0 4px;';
        remove.textContent = '×';
        remove.addEventListener('click', () => {
            const transfer = new DataTransfer();
            Array.from(input.files).forEach((item, index) => {
                if (index !== fileIndex) transfer.items.add(item);
            });
            input.files = transfer.files;
            renderVariantImagePreview(input);
        });
        wrapper.append(image, remove);
        preview.appendChild(wrapper);
    });
}

document.querySelectorAll('.variant-image-input').forEach(input => {
    input.addEventListener('change', () => renderVariantImagePreview(input));
});

document.querySelectorAll('.color-image-input').forEach(input => {
    input.addEventListener('change', () => {
        const preview = input.parentElement.querySelector('.color-image-preview');
        preview.innerHTML = '';
        Array.from(input.files).forEach((file, index) => {
            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.title = 'Ảnh ' + (index + 1);
            image.style.cssText = 'width:64px;height:64px;object-fit:cover;margin-right:6px;border-radius:4px;';
            preview.appendChild(image);
        });
    });
});

document.querySelectorAll('.delete-variant-image').forEach(button => {
    button.addEventListener('click', async () => {
        if (!confirm('Bạn có chắc muốn xóa ảnh này?')) return;
        const response = await fetch('{{ url('admin/variants/images') }}/' + button.dataset.imageId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        if (response.ok && data.status) {
            button.closest('.existing-image').remove();
        } else {
            alert(data.message || 'Không thể xóa ảnh.');
        }
    });
});

document.getElementById('variantsContainer').addEventListener('click', function (event) {
    const button = event.target.closest('.remove-variant');
    if (!button) return;
    const row = button.closest('.variant-row');
    const id = row.querySelector('input[name$="[id]"]').value;
    if (id) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'variants_to_delete[]';
        input.value = id;
        document.querySelector('form').appendChild(input);
    }
    row.remove();
});
</script>

@endsection

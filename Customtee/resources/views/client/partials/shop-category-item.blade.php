@php
    $intSelectedDanhMucs = array_map('intval', (array) ($selectedDanhMucs ?? []));
    $hasChildren = !empty($category->sub_categories) && count($category->sub_categories) > 0;
    $isActive = in_array((int) $category->id, $intSelectedDanhMucs, true);

    // Kiểm tra xem có con cháu nào đang được chọn hay không để tự động mở rộng (auto-expand)
    $hasActiveDescendant = false;
    if ($hasChildren) {
        $checkActive = function($cat) use (&$checkActive, $intSelectedDanhMucs) {
            if (!empty($cat->sub_categories)) {
                foreach ($cat->sub_categories as $sub) {
                    if (in_array((int) $sub->id, $intSelectedDanhMucs, true) || $checkActive($sub)) {
                        return true;
                    }
                }
            }
            return false;
        };
        $hasActiveDescendant = $checkActive($category);
    }

    $isExpanded = $isActive || $hasActiveDescendant;

    $categoryQuery = request()->query();
    unset($categoryQuery['page']);
    $categoryQuery['danh_muc'] = [$category->id];
    $categoryUrl = url('/Shop') . '?' . http_build_query($categoryQuery);
@endphp

<li class="category-accordion-item">
    <div class="category-filter-item d-flex justify-content-between align-items-center py-2 px-2-5 rounded-3 {{ $isActive ? 'active' : '' }}">
        <a href="{{ $categoryUrl }}"
           data-ajax-link="true"
           class="category-link flex-grow-1 text-decoration-none d-flex align-items-center {{ $isActive ? 'text-white font-weight-bold' : ($depth === 0 ? 'text-dark fw-semibold' : 'text-secondary') }}">
            @if($depth > 0)
                <span class="text-muted me-1-5 opacity-75 small">↳</span>
            @endif
            <span class="fs-7">{{ $category->ten_danh_muc }}</span>
        </a>

        @if($hasChildren)
            <button type="button"
                    class="btn-cat-toggle {{ $isExpanded ? 'is-open' : '' }}"
                    data-target="#cat-sub-{{ $category->id }}"
                    aria-label="Mở rộng / Thu gọn danh mục con"
                    title="Mở rộng / Thu gọn">
                <i class="bi bi-chevron-down fs-8"></i>
            </button>
        @else
            <i class="bi bi-chevron-right fs-8 opacity-40 pe-1"></i>
        @endif
    </div>

    @if($hasChildren)
        <ul class="category-sublist list-unstyled mb-0 {{ $isExpanded ? 'is-open' : '' }}"
            id="cat-sub-{{ $category->id }}"
            style="{{ $isExpanded ? 'display: block;' : 'display: none;' }}">
            @foreach($category->sub_categories as $child)
                @include('client.partials.shop-category-item', [
                    'category' => $child,
                    'depth' => $depth + 1,
                    'selectedDanhMucs' => $selectedDanhMucs
                ])
            @endforeach
        </ul>
    @endif
</li>
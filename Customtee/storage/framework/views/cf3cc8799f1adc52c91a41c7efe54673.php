<?php
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
?>

<li class="category-accordion-item">
<li class="category-accordion-item <?php echo e($isExpanded ? 'is-locked-open' : ''); ?>" data-cat-id="<?php echo e($category->id); ?>">
    <div class="category-filter-item d-flex justify-content-between align-items-center py-2 px-2-5 rounded-3 <?php echo e($isActive ? 'active' : ''); ?>">
        <a href="<?php echo e($categoryUrl); ?>"
           data-ajax-link="true"
           class="category-link flex-grow-1 text-decoration-none d-flex align-items-center <?php echo e($isActive ? 'text-white font-weight-bold' : ($depth === 0 ? 'text-dark fw-semibold' : 'text-secondary')); ?>">
            <?php if($depth > 0): ?>
                <span class="text-muted me-1-5 opacity-75 small">↳</span>
            <?php endif; ?>
            <span class="fs-7"><?php echo e($category->ten_danh_muc); ?></span>
        </a>

        <?php if($hasChildren): ?>
            <button type="button"
                    class="btn-cat-toggle <?php echo e($isExpanded ? 'is-open' : ''); ?>"
                    data-target="#cat-sub-<?php echo e($category->id); ?>"
                    aria-label="Mở rộng / Thu gọn danh mục con"
                    title="Mở rộng / Thu gọn">
                <i class="bi bi-chevron-down fs-8"></i>
            </button>
        <?php else: ?>
            <i class="bi bi-chevron-right fs-8 opacity-40 pe-1"></i>
        <?php endif; ?>
    </div>

    <?php if($hasChildren): ?>
        <ul class="category-sublist list-unstyled mb-0 <?php echo e($isExpanded ? 'is-open' : ''); ?>"
            id="cat-sub-<?php echo e($category->id); ?>"
            style="<?php echo e($isExpanded ? 'display: block;' : 'display: none;'); ?>">
            <?php $__currentLoopData = $category->sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('client.partials.shop-category-item', [
                    'category' => $child,
                    'depth' => $depth + 1,
                    'selectedDanhMucs' => $selectedDanhMucs
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</li><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/client/partials/shop-category-item.blade.php ENDPATH**/ ?>
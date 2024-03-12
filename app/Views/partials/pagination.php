<?php if (isset($paging) && $paging->getPageCount() > 1) : ?>
    <nav aria-label="navigation">
        <ul class="pagination pagination-primary">
            <li class="page-item">
                <a class="page-link" href="<?= base_url('dashboard/request-list?page=' . $paging->getFirstPage()) ?>">
                    <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                </a>
            </li>
            <?php for ($i = $paging->getCurrentPage(); $i <= $paging->getPageCount(); $i++) : ?>
                <?php if ($i >= $paging->getCurrentPage() + 3) : ?>
                    <?php break ?>
                <?php endif ?>
                <li class="page-item <?= $i === $paging->getCurrentPage() ? 'active' : '' ?>">
                    <a class="page-link" href="<?= base_url('dashboard/request-list?page=' . $i) ?>"><?= $i ?></a>
                </li>
            <?php endfor ?>
            <li class="page-item">
                <a class="page-link" href="<?= base_url('dashboard/request-list?page=' . $paging->getLastPage()) ?>">
                    <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                </a>
            </li>
        </ul>
    </nav>
<?php endif ?>
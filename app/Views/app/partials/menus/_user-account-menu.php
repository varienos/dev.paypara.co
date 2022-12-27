<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
	<? if(userId != 0): ?>
	<div class="menu-item px-5 my-1">
		<a href="<?= baseUrl('user/detail/'.md5(userId)) ?>" class="menu-link px-5">Account Settings</a>
	</div>
	<? endif; ?>
	<div class="menu-item px-5">
		<a href="<?= baseUrl('secure/signout') ?>" class="menu-link px-5">Sign out</a>
	</div>
</div>
<!--begin::Search-->
<div id="kt_header_search" class="header-search d-flex align-items-center w-lg-250px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
	<?php require appViewPath().'partials/search/partials/_form-inline.php' ?>
	<!--begin::Menu-->
	<div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown w-300px w-md-350px py-7 px-7 overflow-hidden">
		<!--begin::Wrapper-->
		<div data-kt-search-element="wrapper">
			<?php require appViewPath().'partials/search/partials/_results.php' ?>
			<?php require appViewPath().'partials/search/partials/_main.php' ?>
			<?php require appViewPath().'partials/search/partials/_empty.php' ?>
		</div>
		<!--end::Wrapper-->
		<?php require appViewPath().'partials/search/partials/_advanced-options.php' ?>
		<?php require appViewPath().'partials/search/partials/_preferences.php' ?>
	</div>
	<!--end::Menu-->
</div>
<!--end::Search-->
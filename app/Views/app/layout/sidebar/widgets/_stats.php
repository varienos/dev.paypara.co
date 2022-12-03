<!--begin::Statistics Widget-->
<div class="card card-flush card-p-0 shadow-none bg-transparent mb-10">
	<!--begin::Header-->
	<div class="card-header align-items-center border-0">
		<!--begin::Title-->
		<h3 class="card-title fw-bold text-white fs-3">Outgoing Emails</h3>
		<!--end::Title-->
		<!--begin::Toolbar-->
		<div class="card-toolbar">
			<button type="button" class="btn btn-icon btn-icon-white btn-active-color-primary me-n4" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="bottom-end">
				<!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
				<span class="svg-icon svg-icon-2">
					<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor" />
							<rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
							<rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
							<rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
						</g>
					</svg>
				</span>
				<!--end::Svg Icon-->
			</button>
			<?php include 'partials/menus/_menu-2.php' ?>
		</div>
		<!--end::Title-->
	</div>
	<!--end::Header-->
	<!--begin::Body-->
	<div class="card-body">
		<!--begin::Row-->
		<div class="row g-5">
			<!--begin::Col-->
			<div class="col-6">
				<!--begin::Item-->
				<div class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
					<!--begin::Value-->
					<div class="text-white fs-2 fs-xxl-2x fw-bold mb-1" data-kt-countup="true" data-kt-countup-value="160" data-kt-countup-prefix="">0</div>
					<!--begin::Value-->
					<!--begin::Label-->
					<div class="sidebar-text-muted fs-6 fw-bold">Sending</div>
					<!--end::Label-->
				</div>
				<!--end::Item-->
			</div>
			<!--end::Col-->
			<!--begin::Col-->
			<div class="col-6">
				<!--begin::Item-->
				<div class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
					<!--begin::Value-->
					<div class="text-white fs-2 fs-xxl-2x fw-bold mb-1" data-kt-countup="true" data-kt-countup-value="2600" data-kt-countup-prefix="">0</div>
					<!--begin::Value-->
					<!--begin::Label-->
					<div class="sidebar-text-muted fs-6 fw-bold">Sent</div>
					<!--end::Label-->
				</div>
				<!--end::Item-->
			</div>
			<!--end::Col-->
			<!--begin::Col-->
			<div class="col-6">
				<!--begin::Item-->
				<div class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
					<!--begin::Value-->
					<div class="text-white fs-2 fs-xxl-2x fw-bold mb-1" data-kt-countup="true" data-kt-countup-value="2500" data-kt-countup-prefix="">0</div>
					<!--begin::Value-->
					<!--begin::Label-->
					<div class="sidebar-text-muted fs-6 fw-bold">Delivered</div>
					<!--end::Label-->
				</div>
				<!--end::Item-->
			</div>
			<!--end::Col-->
			<!--begin::Col-->
			<div class="col-6">
				<!--begin::Item-->
				<div class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
					<!--begin::Value-->
					<div class="text-white fs-2 fs-xxl-2x fw-bold mb-1" data-kt-countup="true" data-kt-countup-value="11" data-kt-countup-prefix="">0</div>
					<!--begin::Value-->
					<!--begin::Label-->
					<div class="sidebar-text-muted fs-6 fw-bold">Failed</div>
					<!--end::Label-->
				</div>
				<!--end::Item-->
			</div>
			<!--end::Col-->
		</div>
		<!--end::Row-->
	</div>
	<!--end::Card Body-->
</div>
<!--end::Statistics Widget-->
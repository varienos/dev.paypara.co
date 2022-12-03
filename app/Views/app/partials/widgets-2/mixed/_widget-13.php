<!--begin::Mixed Widget 13-->
<div class="card card-xl-stretch border mb-xl-10 theme-dark-bg-body" style="background-color: #cef4cb">
	<!--begin::Body-->
	<div class="card-body d-flex flex-column">
		<!--begin::Wrapper-->
		<div class="d-flex flex-column flex-grow-1">
			<!--begin::Title-->
			<a href="#yatirimlar" class="text-dark text-hover-primary fw-bold fs-1">Yatırım</a>
			<!--end::Title-->
			<!--begin::Chart-->
			<div class="mixed-widget-13-chart" style="height: 100px"></div>
			<!--end::Chart-->
		</div>
		<!--end::Wrapper-->
		<!--begin::Stats-->
		<div class="pt-5">
			<!--begin::Symbol-->
			<span class="text-dark fw-bold fs-2x lh-0">₺</span>
			<!--end::Symbol-->
			<!--begin::Number-->
			<span class="text-dark fw-bold fs-2x me-2 lh-0"><?=number_format(depositDaily(),2) ?></span>
			<!--end::Number-->
		</div>
		<!--end::Stats-->
	</div>
	<!--end::Body-->
</div>
<!--end::Mixed Widget 13-->
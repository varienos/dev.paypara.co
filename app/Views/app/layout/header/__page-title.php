<!--begin::Page title-->
<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', xl: '#kt_header_container'}">
	<!--begin::Heading-->
	<h1 class="d-flex flex-column text-dark fw-bold my-0 fs-2x">👋 Selam <?=user_name ?>,
	<small class=" fs-6 fw-semibold ms-1 pt-1"><? if(pendingProcess()>0){ ?>Bekleyen <?=pendingProcess() ?> işlem var<? }else{ ?>Bekleyen işlem yok<? } ?></small></h1>
	<!--end::Heading-->
</div>
<!--end::Page title=-->
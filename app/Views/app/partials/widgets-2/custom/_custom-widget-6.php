<!--begin::Card widget 2-->
<div class="card border h-lg-100">
  <!--begin::Body-->
  <div class="card-body d-flex justify-content-between align-items-start flex-column">
    <!--begin::Icon-->
    <div class="m-0">
      <!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
      <span class="svg-icon svg-icon-2hx svg-icon-gray-600">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" d="M11 11H13C13.6 11 14 11.4 14 12V21H10V12C10 11.4 10.4 11 11 11ZM16 3V21H20V3C20 2.4 19.6 2 19 2H17C16.4 2 16 2.4 16 3Z" fill="currentColor"/><path d="M21 20H8V16C8 15.4 7.6 15 7 15H5C4.4 15 4 15.4 4 16V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="currentColor"/>
        </svg>
      </span>
      <!--end::Svg Icon-->
    </div>
    <!--end::Icon-->
    <!--begin::Section-->
    <div class="d-flex flex-column my-4">
      <!--begin::Number-->
      <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">
        <span class="fs-1 fw-semibold text-gray-700 me-1 align-self-start">₺</span><?=number_format(depositMonthly()/30,2) ?>
      </span>
      <!--end::Number-->
      <!--begin::Follower-->
      <div class="m-0 mt-3">
        <span class="fw-semibold fs-6 text-gray-700 text-truncate">Ortalama Yatırım</span>
      </div>
      <!--end::Follower-->
    </div>
    <!--end::Section-->
  </div>
  <!--end::Body-->
</div>
<!--begin::Card widget 2-->
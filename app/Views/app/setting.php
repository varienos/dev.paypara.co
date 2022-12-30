<?php require appViewPath().'layout/header/header.php' ?>
<body id="kt_body" class="sidebar-disabled"></body>
<?php require appViewPath().'partials/theme-mode/_init.php' ?>
<?php foreach ($setting as $row) { $param["$row->name"] = $row->value; }?>
<div class="d-flex flex-column flex-root">
	<div class="page d-flex flex-row flex-column-fluid"> <?php require appViewPath().'layout/aside/_base.php' ?> <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
			<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
				<div id="kt_header" class="header">
					<div class="container d-flex flex-stack flex-wrap gap-2" id="kt_header_container">
						<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_container', lg: '#kt_header_container'}">
							<h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Settings</h1>
							<ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
								<li class="breadcrumb-item text-muted">
									<a href="dashboard" class="text-muted">Dashboard</a>
								</li>
								<li class="breadcrumb-item text-dark">Settings</a></li>
							</ul>
						</div>
						<div class="d-flex d-lg-none align-items-center ms-n2 me-2">
							<div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
								<span class="svg-icon svg-icon-1 mt-1">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" /><path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
									</svg>
								</span>
							</div>
							<a href="dashboard" class="d-flex align-items-center">
								<img alt="Logo" src="<?=baseUrl('assets/branding/logo.png') ?>" class="theme-light-show h-30px" />
								<img alt="Logo" src="<?=baseUrl('assets/branding/logo.png') ?>" class="theme-dark-show h-30px" />
							</a>
						</div>
						<div class="d-flex align-items-center flex-shrink-0">
							<div class="d-flex align-items-center">
								<a href="#" class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<span class="svg-icon theme-light-show svg-icon-1">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.9905 5.62598C10.7293 5.62574 9.49646 5.9995 8.44775 6.69997C7.39903 7.40045 6.58159 8.39619 6.09881 9.56126C5.61603 10.7263 5.48958 12.0084 5.73547 13.2453C5.98135 14.4823 6.58852 15.6185 7.48019 16.5104C8.37186 17.4022 9.50798 18.0096 10.7449 18.2557C11.9818 18.5019 13.2639 18.3757 14.429 17.8931C15.5942 17.4106 16.5901 16.5933 17.2908 15.5448C17.9915 14.4962 18.3655 13.2634 18.3655 12.0023C18.3637 10.3119 17.6916 8.69129 16.4964 7.49593C15.3013 6.30056 13.6808 5.62806 11.9905 5.62598Z" fill="currentColor" /><path d="M22.1258 10.8771H20.627C20.3286 10.8771 20.0424 10.9956 19.8314 11.2066C19.6204 11.4176 19.5018 11.7038 19.5018 12.0023C19.5018 12.3007 19.6204 12.5869 19.8314 12.7979C20.0424 13.0089 20.3286 13.1274 20.627 13.1274H22.1258C22.4242 13.1274 22.7104 13.0089 22.9214 12.7979C23.1324 12.5869 23.2509 12.3007 23.2509 12.0023C23.2509 11.7038 23.1324 11.4176 22.9214 11.2066C22.7104 10.9956 22.4242 10.8771 22.1258 10.8771Z" fill="currentColor" /><path d="M11.9905 19.4995C11.6923 19.5 11.4064 19.6187 11.1956 19.8296C10.9848 20.0405 10.8663 20.3265 10.866 20.6247V22.1249C10.866 22.4231 10.9845 22.7091 11.1953 22.9199C11.4062 23.1308 11.6922 23.2492 11.9904 23.2492C12.2886 23.2492 12.5746 23.1308 12.7854 22.9199C12.9963 22.7091 13.1147 22.4231 13.1147 22.1249V20.6247C13.1145 20.3265 12.996 20.0406 12.7853 19.8296C12.5745 19.6187 12.2887 19.5 11.9905 19.4995Z" fill="currentColor" /><path d="M4.49743 12.0023C4.49718 11.704 4.37865 11.4181 4.16785 11.2072C3.95705 10.9962 3.67119 10.8775 3.37298 10.8771H1.87445C1.57603 10.8771 1.28984 10.9956 1.07883 11.2066C0.867812 11.4176 0.749266 11.7038 0.749266 12.0023C0.749266 12.3007 0.867812 12.5869 1.07883 12.7979C1.28984 13.0089 1.57603 13.1274 1.87445 13.1274H3.37299C3.6712 13.127 3.95706 13.0083 4.16785 12.7973C4.37865 12.5864 4.49718 12.3005 4.49743 12.0023Z" fill="currentColor" /><path d="M11.9905 4.50058C12.2887 4.50012 12.5745 4.38141 12.7853 4.17048C12.9961 3.95954 13.1147 3.67361 13.1149 3.3754V1.87521C13.1149 1.57701 12.9965 1.29103 12.7856 1.08017C12.5748 0.869313 12.2888 0.750854 11.9906 0.750854C11.6924 0.750854 11.4064 0.869313 11.1955 1.08017C10.9847 1.29103 10.8662 1.57701 10.8662 1.87521V3.3754C10.8664 3.67359 10.9849 3.95952 11.1957 4.17046C11.4065 4.3814 11.6923 4.50012 11.9905 4.50058Z" fill="currentColor" /><path d="M18.8857 6.6972L19.9465 5.63642C20.0512 5.53209 20.1343 5.40813 20.1911 5.27163C20.2479 5.13513 20.2772 4.98877 20.2774 4.84093C20.2775 4.69309 20.2485 4.54667 20.192 4.41006C20.1355 4.27344 20.0526 4.14932 19.948 4.04478C19.8435 3.94024 19.7194 3.85734 19.5828 3.80083C19.4462 3.74432 19.2997 3.71531 19.1519 3.71545C19.0041 3.7156 18.8577 3.7449 18.7212 3.80167C18.5847 3.85845 18.4607 3.94159 18.3564 4.04633L17.2956 5.10714C17.1909 5.21147 17.1077 5.33543 17.0509 5.47194C16.9942 5.60844 16.9649 5.7548 16.9647 5.90264C16.9646 6.05048 16.9936 6.19689 17.0501 6.33351C17.1066 6.47012 17.1895 6.59425 17.294 6.69878C17.3986 6.80332 17.5227 6.88621 17.6593 6.94272C17.7959 6.99923 17.9424 7.02824 18.0902 7.02809C18.238 7.02795 18.3844 6.99865 18.5209 6.94187C18.6574 6.88509 18.7814 6.80195 18.8857 6.6972Z" fill="currentColor" /><path d="M18.8855 17.3073C18.7812 17.2026 18.6572 17.1195 18.5207 17.0627C18.3843 17.006 18.2379 16.9767 18.0901 16.9766C17.9423 16.9764 17.7959 17.0055 17.6593 17.062C17.5227 17.1185 17.3986 17.2014 17.2941 17.3059C17.1895 17.4104 17.1067 17.5345 17.0501 17.6711C16.9936 17.8077 16.9646 17.9541 16.9648 18.1019C16.9649 18.2497 16.9942 18.3961 17.0509 18.5326C17.1077 18.6691 17.1908 18.793 17.2955 18.8974L18.3563 19.9582C18.4606 20.0629 18.5846 20.146 18.721 20.2027C18.8575 20.2595 19.0039 20.2887 19.1517 20.2889C19.2995 20.289 19.4459 20.26 19.5825 20.2035C19.7191 20.147 19.8432 20.0641 19.9477 19.9595C20.0523 19.855 20.1351 19.7309 20.1916 19.5943C20.2482 19.4577 20.2772 19.3113 20.277 19.1635C20.2769 19.0157 20.2476 18.8694 20.1909 18.7329C20.1341 18.5964 20.051 18.4724 19.9463 18.3681L18.8855 17.3073Z" fill="currentColor" /><path d="M5.09528 17.3072L4.0345 18.368C3.92972 18.4723 3.84655 18.5963 3.78974 18.7328C3.73294 18.8693 3.70362 19.0156 3.70346 19.1635C3.7033 19.3114 3.7323 19.4578 3.78881 19.5944C3.84532 19.7311 3.92822 19.8552 4.03277 19.9598C4.13732 20.0643 4.26147 20.1472 4.3981 20.2037C4.53473 20.2602 4.68117 20.2892 4.82902 20.2891C4.97688 20.2889 5.12325 20.2596 5.25976 20.2028C5.39627 20.146 5.52024 20.0628 5.62456 19.958L6.68536 18.8973C6.79007 18.7929 6.87318 18.6689 6.92993 18.5325C6.98667 18.396 7.01595 18.2496 7.01608 18.1018C7.01621 17.954 6.98719 17.8076 6.93068 17.671C6.87417 17.5344 6.79129 17.4103 6.68676 17.3058C6.58224 17.2012 6.45813 17.1183 6.32153 17.0618C6.18494 17.0053 6.03855 16.9763 5.89073 16.9764C5.74291 16.9766 5.59657 17.0058 5.46007 17.0626C5.32358 17.1193 5.19962 17.2024 5.09528 17.3072Z" fill="currentColor" /><path d="M5.09541 6.69715C5.19979 6.8017 5.32374 6.88466 5.4602 6.94128C5.59665 6.9979 5.74292 7.02708 5.89065 7.02714C6.03839 7.0272 6.18469 6.99815 6.32119 6.94164C6.45769 6.88514 6.58171 6.80228 6.68618 6.69782C6.79064 6.59336 6.87349 6.46933 6.93 6.33283C6.9865 6.19633 7.01556 6.05003 7.01549 5.9023C7.01543 5.75457 6.98625 5.60829 6.92963 5.47184C6.87301 5.33539 6.79005 5.21143 6.6855 5.10706L5.6247 4.04626C5.5204 3.94137 5.39643 3.8581 5.25989 3.80121C5.12335 3.74432 4.97692 3.71493 4.82901 3.71472C4.68109 3.71452 4.53458 3.7435 4.39789 3.80001C4.26119 3.85652 4.13699 3.93945 4.03239 4.04404C3.9278 4.14864 3.84487 4.27284 3.78836 4.40954C3.73185 4.54624 3.70287 4.69274 3.70308 4.84066C3.70329 4.98858 3.73268 5.135 3.78957 5.27154C3.84646 5.40808 3.92974 5.53205 4.03462 5.63635L5.09541 6.69715Z" fill="currentColor" />
										</svg>
									</span>
									<span class="svg-icon theme-dark-show svg-icon-1">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.0647 5.43757C19.3421 5.43757 19.567 5.21271 19.567 4.93534C19.567 4.65796 19.3421 4.43311 19.0647 4.43311C18.7874 4.43311 18.5625 4.65796 18.5625 4.93534C18.5625 5.21271 18.7874 5.43757 19.0647 5.43757Z" fill="currentColor" /><path d="M20.0692 9.48884C20.3466 9.48884 20.5714 9.26398 20.5714 8.98661C20.5714 8.70923 20.3466 8.48438 20.0692 8.48438C19.7918 8.48438 19.567 8.70923 19.567 8.98661C19.567 9.26398 19.7918 9.48884 20.0692 9.48884Z" fill="currentColor" /><path d="M12.0335 20.5714C15.6943 20.5714 18.9426 18.2053 20.1168 14.7338C20.1884 14.5225 20.1114 14.289 19.9284 14.161C19.746 14.034 19.5003 14.0418 19.3257 14.1821C18.2432 15.0546 16.9371 15.5156 15.5491 15.5156C12.2257 15.5156 9.48884 12.8122 9.48884 9.48886C9.48884 7.41079 10.5773 5.47137 12.3449 4.35752C12.5342 4.23832 12.6 4.00733 12.5377 3.79251C12.4759 3.57768 12.2571 3.42859 12.0335 3.42859C7.32556 3.42859 3.42857 7.29209 3.42857 12C3.42857 16.7079 7.32556 20.5714 12.0335 20.5714Z" fill="currentColor" /><path d="M13.0379 7.47998C13.8688 7.47998 14.5446 8.15585 14.5446 8.98668C14.5446 9.26428 14.7693 9.48891 15.0469 9.48891C15.3245 9.48891 15.5491 9.26428 15.5491 8.98668C15.5491 8.15585 16.225 7.47998 17.0558 7.47998C17.3334 7.47998 17.558 7.25535 17.558 6.97775C17.558 6.70015 17.3334 6.47552 17.0558 6.47552C16.225 6.47552 15.5491 5.76616 15.5491 4.93534C15.5491 4.65774 15.3245 4.43311 15.0469 4.43311C14.7693 4.43311 14.5446 4.65774 14.5446 4.93534C14.5446 5.76616 13.8688 6.47552 13.0379 6.47552C12.7603 6.47552 12.5357 6.70015 12.5357 6.97775C12.5357 7.25535 12.7603 7.47998 13.0379 7.47998Z" fill="currentColor" />
										</svg>
									</span>
								</a>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px" data-kt-menu="true" data-kt-element="theme-mode-menu">
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
											<span class="menu-icon" data-kt-element="icon">
												<span class="svg-icon svg-icon-3">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.9905 5.62598C10.7293 5.62574 9.49646 5.9995 8.44775 6.69997C7.39903 7.40045 6.58159 8.39619 6.09881 9.56126C5.61603 10.7263 5.48958 12.0084 5.73547 13.2453C5.98135 14.4823 6.58852 15.6185 7.48019 16.5104C8.37186 17.4022 9.50798 18.0096 10.7449 18.2557C11.9818 18.5019 13.2639 18.3757 14.429 17.8931C15.5942 17.4106 16.5901 16.5933 17.2908 15.5448C17.9915 14.4962 18.3655 13.2634 18.3655 12.0023C18.3637 10.3119 17.6916 8.69129 16.4964 7.49593C15.3013 6.30056 13.6808 5.62806 11.9905 5.62598Z" fill="currentColor" /><path d="M22.1258 10.8771H20.627C20.3286 10.8771 20.0424 10.9956 19.8314 11.2066C19.6204 11.4176 19.5018 11.7038 19.5018 12.0023C19.5018 12.3007 19.6204 12.5869 19.8314 12.7979C20.0424 13.0089 20.3286 13.1274 20.627 13.1274H22.1258C22.4242 13.1274 22.7104 13.0089 22.9214 12.7979C23.1324 12.5869 23.2509 12.3007 23.2509 12.0023C23.2509 11.7038 23.1324 11.4176 22.9214 11.2066C22.7104 10.9956 22.4242 10.8771 22.1258 10.8771Z" fill="currentColor" /><path d="M11.9905 19.4995C11.6923 19.5 11.4064 19.6187 11.1956 19.8296C10.9848 20.0405 10.8663 20.3265 10.866 20.6247V22.1249C10.866 22.4231 10.9845 22.7091 11.1953 22.9199C11.4062 23.1308 11.6922 23.2492 11.9904 23.2492C12.2886 23.2492 12.5746 23.1308 12.7854 22.9199C12.9963 22.7091 13.1147 22.4231 13.1147 22.1249V20.6247C13.1145 20.3265 12.996 20.0406 12.7853 19.8296C12.5745 19.6187 12.2887 19.5 11.9905 19.4995Z" fill="currentColor" /><path d="M4.49743 12.0023C4.49718 11.704 4.37865 11.4181 4.16785 11.2072C3.95705 10.9962 3.67119 10.8775 3.37298 10.8771H1.87445C1.57603 10.8771 1.28984 10.9956 1.07883 11.2066C0.867812 11.4176 0.749266 11.7038 0.749266 12.0023C0.749266 12.3007 0.867812 12.5869 1.07883 12.7979C1.28984 13.0089 1.57603 13.1274 1.87445 13.1274H3.37299C3.6712 13.127 3.95706 13.0083 4.16785 12.7973C4.37865 12.5864 4.49718 12.3005 4.49743 12.0023Z" fill="currentColor" /><path d="M11.9905 4.50058C12.2887 4.50012 12.5745 4.38141 12.7853 4.17048C12.9961 3.95954 13.1147 3.67361 13.1149 3.3754V1.87521C13.1149 1.57701 12.9965 1.29103 12.7856 1.08017C12.5748 0.869313 12.2888 0.750854 11.9906 0.750854C11.6924 0.750854 11.4064 0.869313 11.1955 1.08017C10.9847 1.29103 10.8662 1.57701 10.8662 1.87521V3.3754C10.8664 3.67359 10.9849 3.95952 11.1957 4.17046C11.4065 4.3814 11.6923 4.50012 11.9905 4.50058Z" fill="currentColor" /><path d="M18.8857 6.6972L19.9465 5.63642C20.0512 5.53209 20.1343 5.40813 20.1911 5.27163C20.2479 5.13513 20.2772 4.98877 20.2774 4.84093C20.2775 4.69309 20.2485 4.54667 20.192 4.41006C20.1355 4.27344 20.0526 4.14932 19.948 4.04478C19.8435 3.94024 19.7194 3.85734 19.5828 3.80083C19.4462 3.74432 19.2997 3.71531 19.1519 3.71545C19.0041 3.7156 18.8577 3.7449 18.7212 3.80167C18.5847 3.85845 18.4607 3.94159 18.3564 4.04633L17.2956 5.10714C17.1909 5.21147 17.1077 5.33543 17.0509 5.47194C16.9942 5.60844 16.9649 5.7548 16.9647 5.90264C16.9646 6.05048 16.9936 6.19689 17.0501 6.33351C17.1066 6.47012 17.1895 6.59425 17.294 6.69878C17.3986 6.80332 17.5227 6.88621 17.6593 6.94272C17.7959 6.99923 17.9424 7.02824 18.0902 7.02809C18.238 7.02795 18.3844 6.99865 18.5209 6.94187C18.6574 6.88509 18.7814 6.80195 18.8857 6.6972Z" fill="currentColor" /><path d="M18.8855 17.3073C18.7812 17.2026 18.6572 17.1195 18.5207 17.0627C18.3843 17.006 18.2379 16.9767 18.0901 16.9766C17.9423 16.9764 17.7959 17.0055 17.6593 17.062C17.5227 17.1185 17.3986 17.2014 17.2941 17.3059C17.1895 17.4104 17.1067 17.5345 17.0501 17.6711C16.9936 17.8077 16.9646 17.9541 16.9648 18.1019C16.9649 18.2497 16.9942 18.3961 17.0509 18.5326C17.1077 18.6691 17.1908 18.793 17.2955 18.8974L18.3563 19.9582C18.4606 20.0629 18.5846 20.146 18.721 20.2027C18.8575 20.2595 19.0039 20.2887 19.1517 20.2889C19.2995 20.289 19.4459 20.26 19.5825 20.2035C19.7191 20.147 19.8432 20.0641 19.9477 19.9595C20.0523 19.855 20.1351 19.7309 20.1916 19.5943C20.2482 19.4577 20.2772 19.3113 20.277 19.1635C20.2769 19.0157 20.2476 18.8694 20.1909 18.7329C20.1341 18.5964 20.051 18.4724 19.9463 18.3681L18.8855 17.3073Z" fill="currentColor" /><path d="M5.09528 17.3072L4.0345 18.368C3.92972 18.4723 3.84655 18.5963 3.78974 18.7328C3.73294 18.8693 3.70362 19.0156 3.70346 19.1635C3.7033 19.3114 3.7323 19.4578 3.78881 19.5944C3.84532 19.7311 3.92822 19.8552 4.03277 19.9598C4.13732 20.0643 4.26147 20.1472 4.3981 20.2037C4.53473 20.2602 4.68117 20.2892 4.82902 20.2891C4.97688 20.2889 5.12325 20.2596 5.25976 20.2028C5.39627 20.146 5.52024 20.0628 5.62456 19.958L6.68536 18.8973C6.79007 18.7929 6.87318 18.6689 6.92993 18.5325C6.98667 18.396 7.01595 18.2496 7.01608 18.1018C7.01621 17.954 6.98719 17.8076 6.93068 17.671C6.87417 17.5344 6.79129 17.4103 6.68676 17.3058C6.58224 17.2012 6.45813 17.1183 6.32153 17.0618C6.18494 17.0053 6.03855 16.9763 5.89073 16.9764C5.74291 16.9766 5.59657 17.0058 5.46007 17.0626C5.32358 17.1193 5.19962 17.2024 5.09528 17.3072Z" fill="currentColor" /><path d="M5.09541 6.69715C5.19979 6.8017 5.32374 6.88466 5.4602 6.94128C5.59665 6.9979 5.74292 7.02708 5.89065 7.02714C6.03839 7.0272 6.18469 6.99815 6.32119 6.94164C6.45769 6.88514 6.58171 6.80228 6.68618 6.69782C6.79064 6.59336 6.87349 6.46933 6.93 6.33283C6.9865 6.19633 7.01556 6.05003 7.01549 5.9023C7.01543 5.75457 6.98625 5.60829 6.92963 5.47184C6.87301 5.33539 6.79005 5.21143 6.6855 5.10706L5.6247 4.04626C5.5204 3.94137 5.39643 3.8581 5.25989 3.80121C5.12335 3.74432 4.97692 3.71493 4.82901 3.71472C4.68109 3.71452 4.53458 3.7435 4.39789 3.80001C4.26119 3.85652 4.13699 3.93945 4.03239 4.04404C3.9278 4.14864 3.84487 4.27284 3.78836 4.40954C3.73185 4.54624 3.70287 4.69274 3.70308 4.84066C3.70329 4.98858 3.73268 5.135 3.78957 5.27154C3.84646 5.40808 3.92974 5.53205 4.03462 5.63635L5.09541 6.69715Z" fill="currentColor" />
													</svg>
												</span>
											</span>
											<span class="menu-title">Light</span>
										</a>
									</div>
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
											<span class="menu-icon" data-kt-element="icon">
												<span class="svg-icon svg-icon-3">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.0647 5.43757C19.3421 5.43757 19.567 5.21271 19.567 4.93534C19.567 4.65796 19.3421 4.43311 19.0647 4.43311C18.7874 4.43311 18.5625 4.65796 18.5625 4.93534C18.5625 5.21271 18.7874 5.43757 19.0647 5.43757Z" fill="currentColor" /><path d="M20.0692 9.48884C20.3466 9.48884 20.5714 9.26398 20.5714 8.98661C20.5714 8.70923 20.3466 8.48438 20.0692 8.48438C19.7918 8.48438 19.567 8.70923 19.567 8.98661C19.567 9.26398 19.7918 9.48884 20.0692 9.48884Z" fill="currentColor" /><path d="M12.0335 20.5714C15.6943 20.5714 18.9426 18.2053 20.1168 14.7338C20.1884 14.5225 20.1114 14.289 19.9284 14.161C19.746 14.034 19.5003 14.0418 19.3257 14.1821C18.2432 15.0546 16.9371 15.5156 15.5491 15.5156C12.2257 15.5156 9.48884 12.8122 9.48884 9.48886C9.48884 7.41079 10.5773 5.47137 12.3449 4.35752C12.5342 4.23832 12.6 4.00733 12.5377 3.79251C12.4759 3.57768 12.2571 3.42859 12.0335 3.42859C7.32556 3.42859 3.42857 7.29209 3.42857 12C3.42857 16.7079 7.32556 20.5714 12.0335 20.5714Z" fill="currentColor" /><path d="M13.0379 7.47998C13.8688 7.47998 14.5446 8.15585 14.5446 8.98668C14.5446 9.26428 14.7693 9.48891 15.0469 9.48891C15.3245 9.48891 15.5491 9.26428 15.5491 8.98668C15.5491 8.15585 16.225 7.47998 17.0558 7.47998C17.3334 7.47998 17.558 7.25535 17.558 6.97775C17.558 6.70015 17.3334 6.47552 17.0558 6.47552C16.225 6.47552 15.5491 5.76616 15.5491 4.93534C15.5491 4.65774 15.3245 4.43311 15.0469 4.43311C14.7693 4.43311 14.5446 4.65774 14.5446 4.93534C14.5446 5.76616 13.8688 6.47552 13.0379 6.47552C12.7603 6.47552 12.5357 6.70015 12.5357 6.97775C12.5357 7.25535 12.7603 7.47998 13.0379 7.47998Z" fill="currentColor" />
													</svg>
												</span>
											</span>
											<span class="menu-title">Dark</span>
										</a>
									</div>
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
											<span class="menu-icon" data-kt-element="icon">
												<span class="svg-icon svg-icon-3">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.34375 3.9463V15.2178C1.34375 16.119 2.08105 16.8563 2.98219 16.8563H8.65093V19.4594H6.15702C5.38853 19.4594 4.75981 19.9617 4.75981 20.5757V21.6921H19.2403V20.5757C19.2403 19.9617 18.6116 19.4594 17.8431 19.4594H15.3492V16.8563H21.0179C21.919 16.8563 22.6562 16.119 22.6562 15.2178V3.9463C22.6562 3.04516 21.9189 2.30786 21.0179 2.30786H2.98219C2.08105 2.30786 1.34375 3.04516 1.34375 3.9463ZM12.9034 9.9016C13.241 9.98792 13.5597 10.1216 13.852 10.2949L15.0393 9.4353L15.9893 10.3853L15.1297 11.5727C15.303 11.865 15.4366 12.1837 15.523 12.5212L16.97 12.7528V13.4089H13.9851C13.9766 12.3198 13.0912 11.4394 12 11.4394C10.9089 11.4394 10.0235 12.3198 10.015 13.4089H7.03006V12.7528L8.47712 12.5211C8.56345 12.1836 8.69703 11.8649 8.87037 11.5727L8.0107 10.3853L8.96078 9.4353L10.148 10.2949C10.4404 10.1215 10.759 9.98788 11.0966 9.9016L11.3282 8.45467H12.6718L12.9034 9.9016ZM16.1353 7.93758C15.6779 7.93758 15.3071 7.56681 15.3071 7.1094C15.3071 6.652 15.6779 6.28122 16.1353 6.28122C16.5926 6.28122 16.9634 6.652 16.9634 7.1094C16.9634 7.56681 16.5926 7.93758 16.1353 7.93758ZM2.71385 14.0964V3.90518C2.71385 3.78023 2.81612 3.67796 2.94107 3.67796H21.0589C21.1839 3.67796 21.2861 3.78023 21.2861 3.90518V14.0964C15.0954 14.0964 8.90462 14.0964 2.71385 14.0964Z" fill="currentColor" />
													</svg>
												</span>
											</span>
											<span class="menu-title">System</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<style>
					.border-hover,
					.border-active-dark.active {
						--bs-border-width: 2px !important;
						border-color: var(--kt-dark) !important
					}
				</style>
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<div class="container-xxl" id="kt_container">
						<div class="card card-flush mb-5 mb-xxl-10 border" style="padding-bottom: 1px;">
							<div class="card-body pt-3 pb-0">
								<ul class="nav nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-semibold">
									<li class="nav-item" <?=view_setting!==true?"auth=\"false\"":null; ?>>
										<a class="nav-link pt-5 pb-7 text-active-dark border-0 border-bottom border-hover border-active-dark me-5 active" data-bs-toggle="tab" href="#settings-general">General</a>
									</li>
									<li class="nav-item" <?=view_setting!==true?"auth=\"false\"":null; ?>>
										<a class="nav-link pt-5 pb-7 text-active-dark border-0 border-bottom border-hover border-active-dark me-5" data-bs-toggle="tab" href="#settings-methods">Methods</a>
									</li>
									<li class="nav-item" <?=view_firm!==true?"auth=\"false\"":null; ?>>
										<a class="nav-link pt-5 pb-7 text-active-dark border-0 border-bottom border-hover border-active-dark me-5  <?=view_setting!==true&&view_firm===true?"active":null; ?>" data-bs-toggle="tab" href="#settings-firms">Firms</a>
									</li>
									<li class="nav-item" <?=view_setting!==true?"auth=\"false\"":null; ?>>
										<a class="nav-link pt-5 pb-7 text-active-dark border-0 border-bottom border-hover border-active-dark" data-bs-toggle="tab" href="#settings-logs">Logs</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="settings-general" role="tabpanel"  <?=view_setting!==true?"auth=\"false\"":null; ?>>
								<form id="genel-limits-form" class="form" action="javascript:" data-set="setting" method="post" enctype="multipart/form-data">
									<div class="card mb-5 mb-xxl-10 border">
										<div class="card-header">
											<div class="card-title m-0">
												<h3>Payment Limits</h3>
											</div>
											<div class="card-toolbar">
												<div class="w-200px">
													<select class="form-select form-select-solid border" data-control="select2" data-hide-search="true">
														<option value="1" selected>All Firms</option>
														<option value="2">Firm 1</option>
														<option value="3">Firm 2</option>
													</select>
												</div>
											</div>
										</div>
										<div class="card-body p-9">
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Min. Deposit Limit</label>
													<label class="fw-semibold text-gray-600 lh-sm">Minimum amount of deposit for transactions</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<span class="input-group-text border">₺</span>
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="minDeposit" data-default="250" value="<?=$param["minDeposit"] ?>" />
													</div>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Max. Deposit Limit</label>
													<label class="fw-semibold text-gray-600 lh-sm">Maximum amount of deposit for transactions</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<span class="input-group-text border">₺</span>
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="maxDeposit" data-default="15000" value="<?=$param["maxDeposit"] ?>" />
													</div>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Min. Withdrawal Limit</label>
													<label class="fw-semibold text-gray-600 lh-sm">Minimum amount of withdrawal for transactions</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<span class="input-group-text border">₺</span>
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="minWithdraw" data-default="250" value="<?=$param["minWithdraw"] ?>" />
													</div>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Max. Withdrawal Limit</label>
													<label class="fw-semibold text-gray-600 lh-sm">Maximum amount of withdrawal for transactions</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<span class="input-group-text border">₺</span>
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="maxWithdraw" data-default="15000" value="<?=$param["maxWithdraw"] ?>" />
													</div>
												</div>
											</div>
										</div>
										<? if(edit_setting === true): ?>
										<div class="card-footer p-5">
											<div class="d-flex flex-end">
												<button type="button" id="resetSetting" data-form-id="genel-limits-form" class="btn btn-sm btn-light rounded fs-7 w-100px me-3">Reset</button>
												<button type="button" id="updateSetting" data-form-id="genel-limits-form" class="btn btn-sm btn-light-primary rounded fs-7 w-100px">Save</button>
											</div>
										</div>
										<? endif ?>
									</div>
								</form>
								<form id="genel-times-form" class="form" action="javascript:" data-set="setting" method="post" enctype="multipart/form-data">
									<div class="card mb-5 mb-xxl-10 border">
										<div class="card-header">
											<div class="card-title m-0">
												<h3>Duration Based Definitions</h3>
											</div>
										</div>
										<div class="card-body p-9">
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Transaction revision time</label>
													<label class="fw-semibold text-gray-600 lh-sm">Time limit for revising transactions</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<span class="input-group-text border">second</span>
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="requestEditTime" data-default="30" value="<?=$param["requestEditTime"] ?>" />
													</div>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Token expiration time</label>
													<label class="fw-semibold text-gray-600 lh-sm">Expiration time for iframe tokens</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<span class="input-group-text border">second</span>
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="tokenTimeout" data-default="120" value="<?=$param["tokenTimeout"] ?>" />
													</div>
												</div>
											</div>
										</div>
										<? if(edit_setting === true): ?>
										<div class="card-footer p-5">
											<div class="d-flex flex-end">
												<button type="button" id="resetSetting" data-form-id="genel-times-form" class="btn btn-sm btn-light rounded fs-7 w-100px me-3">Reset</button>
												<button type="button" id="updateSetting" data-form-id="genel-times-form" class="btn btn-sm btn-light-primary rounded fs-7 w-100px">Save</button>
											</div>
										</div>
										<? endif ?>
									</div>
								</form>
								<div class="card mb-5 mb-xxl-10 border">
									<div class="card-header bg-light-danger">
										<div class="card-title m-0">
											<h3>Maintenance Mode</h3>
										</div>
									</div>
									<form id="maintenance-form" class="form" action="javascript:" data-set="setting" method="post" enctype="multipart/form-data">
										<div class="card-body p-9">
											<div class="notice d-flex justify-content-between bg-light-danger rounded border-danger border border-dashed p-6">
												<div class="d-flex">
													<div class="svg-icon svg-icon-2tx svg-icon-danger me-4">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
															<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
															<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
														</svg>
													</div>
													<div class="d-flex flex-column">
														<h4 class="text-gray-900 fw-bold">Warning!</h4>
														<div class="text-gray-700 fs-6 fw-semibold">Activating maintenance mode will halt all transactions throughout the system!</div>
													</div>
												</div>
												<div class="d-flex">
													<label class="form-check form-switch form-switch-md form-check-custom form-check-danger form-check-solid">
														<label class="col-form-label fw-semibold p-0 fs-4 lh-sm me-3">Maintenance:</label>
														<input class="form-check-input w-70px h-30px border border-gray-500" type="checkbox" <?= edit_setting !== true ? "disabled" : null; ?> name="maintenanceStatus" data-set="statusSwitch" <? if($param["maintenanceStatus"]=="on" ): ?>checked="checked"
														<? endif; ?> value="on"> </label>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="tab-pane fade" id="settings-methods" role="tabpanel">
								<form id="methods-matching-form" class="form" action="javascript:" data-set="setting" method="post" enctype="multipart/form-data">
									<div class="card mb-5 mb-xxl-10 border">
										<div class="card-header">
											<div class="card-title m-0">
												<h3>Matching System</h3>
											</div>
											<div class="card-toolbar">
												<label class="form-check form-switch form-switch-sm form-check-success form-check-custom form-check-solid">
													<span class="form-check-label me-2">System Status</span>
													<input class="form-check-input w-40px" type="checkbox" <?= edit_setting !== true ? "disabled" : null; ?> value="on" name="matchStatus" data-set="statusSwitch" <? if($param["matchStatus"]=="on" ): ?>checked="checked"
													<? endif; ?>> </label>
											</div>
										</div>
										<div class="card-body p-9">
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Matching System Threshold</label>
													<label class="fw-semibold text-gray-600 lh-sm">Matching account is shared for equal and above amounts</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<span class="input-group-text border">₺</span>
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="matchAmountLimit" data-default="1000" value="<?=$param["matchAmountLimit"] ?>" />
													</div>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Default Match Count</label>
													<label class="fw-semibold text-gray-600 lh-sm">Max number of clients an account can be matched with</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" max="10" maxlength="2" name="defaultMatchLimit" data-default="5" value="<?=$param["defaultMatchLimit"] ?>" />
													</div>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Active Firms</label>
													<label class="fw-semibold text-gray-600 lh-sm">Firms where the matching system will be active</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<select class="form-select form-select-solid border" data-control="select2" <?= edit_setting !== true ? "disabled" : null; ?> name="matchStatusSite[]" data-close-on-select="false" data-placeholder="All firms" data-allow-clear="true" multiple="multiple">
														<option></option>
														<? $clientArray = explode(",", $param["matchStatusSite"]) ?>
														<? foreach($clientSelect as $client){ ?>
														<option value="<?=$client->id ?>" <? if(in_array($client->id,$clientArray)) echo "selected" ?>><?=$client->site_name ?></option>
														<? } ?>
													</select>
												</div>
											</div>
										</div>
										<? if(edit_setting === true): ?>
										<div class="card-footer p-5">
											<div class="d-flex flex-end">
												<button type="button" id="resetSetting" data-form-id="methods-matching-form" class="btn btn-sm btn-light rounded fs-7 w-100px me-3">Reset</button>
												<button type="button" id="updateSetting" data-form-id="methods-matching-form" class="btn btn-sm btn-light-primary rounded fs-7 w-100px">Save</button>
											</div>
										</div>
										<? endif ?>
									</div>
								</form>
								<form id="methods-cross-form" class="form" action="javascript:" data-set="setting" method="post" enctype="multipart/form-data">
									<div class="card mb-5 mb-xxl-10 border">
										<div class="card-header">
											<div class="card-title m-0">
												<h3>Cross System</h3>
											</div>
											<div class="card-toolbar">
												<label class="form-check form-switch form-switch-sm form-check-success form-check-custom form-check-solid">
													<span class="form-check-label me-2">System Status</span>
													<input class="form-check-input w-40px" type="checkbox" <?= edit_setting !== true ? "disabled" : null; ?> name="crossStatus" data-set="statusSwitch" <? if($param["crossStatus"]=="on" ): ?>checked="checked"
													<? endif; ?> value="on"> </label>
											</div>
										</div>
										<div class="card-body p-9">
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Active Firms</label>
													<label class="fw-semibold text-gray-600 lh-sm">Firms where the cross system will be active</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<select class="form-select form-select-solid border" data-control="select2" <?= edit_setting !== true ? "disabled" : null; ?> data-placeholder="All firms" name="crossStatusSite[]" data-close-on-select="false" data-allow-clear="true" multiple="multiple">
														<option></option>
														<? $clientArray = explode(",", $param["crossStatusSite"]) ?>
														<? foreach($clientSelect as $client){ ?>
														<option value="<?=$client->id ?>" <? if(in_array($client->id,$clientArray)) echo "selected" ?>><?=$client->site_name ?></option>
														<? } ?>
													</select>
												</div>
											</div>
										</div>
										<? if(edit_setting === true): ?>
										<div class="card-footer p-5">
											<div class="d-flex flex-end">
												<button type="button" id="resetSetting" data-form-id="methods-cross-form" class="btn btn-sm btn-light rounded fs-7 w-100px me-3">Reset</button>
												<button type="button" id="updateSetting" data-form-id="methods-cross-form" class="btn btn-sm btn-light-primary rounded fs-7 w-100px">Save</button>
											</div>
										</div>
										<? endif ?>
									</div>
								</form>
								<form id="methods-pos-form" class="form" action="javascript:" data-set="setting" method="post" enctype="multipart/form-data">
									<div class="card mb-5 mb-xxl-10 border">
										<div class="card-header">
											<div class="card-title m-0">
												<h3>Virtual POS System</h3>
											</div>
											<div class="card-toolbar">
												<label class="form-check form-switch form-switch-sm form-check-success form-check-custom form-check-solid">
													<span class="form-check-label me-2">System Status</span>
													<input class="form-check-input w-40px" type="checkbox" <?= edit_setting !== true ? "disabled" : null; ?> name="posStatus" data-set="statusSwitch" <? if($param["posStatus"]=="on" ): ?>checked="checked"
													<? endif; ?> value="on"> </label>
											</div>
										</div>
										<div class="card-body p-9">
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Secret Key</label>
													<label class="fw-semibold text-gray-600 lh-sm">POS API Secret Key</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="posApi" data-default="" value="<?=$param["posApi"] ?>" />
													</div>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Publishable Key</label>
													<label class="fw-semibold text-gray-600 lh-sm">POS API Publishable Key</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="posSecret" data-default="" value="<?=$param["posSecret"] ?>" />
													</div>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Active Firms</label>
													<label class="fw-semibold text-gray-600 lh-sm">Firms where the POS system will be active</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<select class="form-select form-select-solid border" data-control="select2" <?= edit_setting !== true ? "disabled" : null; ?> name="posStatusSite[]" data-close-on-select="false" data-placeholder="All firms" data-allow-clear="true" multiple="multiple">
														<option></option>
														<? $clientArray = explode(",", $param["posStatusSite"]) ?>
														<? foreach($clientSelect as $client){ ?>
														<option value="<?=$client->id ?>" <? if(in_array($client->id,$clientArray)) echo "selected" ?>><?=$client->site_name ?></option>
														<? } ?>
													</select>
												</div>
											</div>
										</div>
										<? if(edit_setting === true): ?>
										<div class="card-footer p-5">
											<div class="d-flex flex-end">
												<button type="button" id="resetSetting" data-form-id="methods-pos-form" class="btn btn-sm btn-light rounded fs-7 w-100px me-3">Reset</button>
												<button type="button" id="updateSetting" data-form-id="methods-pos-form" class="btn btn-sm btn-light-primary rounded fs-7 w-100px">Save</button>
											</div>
										</div>
										<? endif ?>
									</div>
								</form>
								<form id="methods-bank-form" class="form" action="javascript:" data-set="setting" method="post" enctype="multipart/form-data">
									<div class="card mb-5 mb-xxl-10 border">
										<div class="card-header">
											<div class="card-title m-0">
												<h3>Bank System</h3>
											</div>
											<div class="card-toolbar">
												<label class="form-check form-switch form-switch-sm form-check-success form-check-custom form-check-solid">
													<span class="form-check-label me-2">System Status</span>
													<input class="form-check-input w-40px" type="checkbox" <?= edit_setting !== true ? "disabled" : null; ?> name="bankStatus" data-set="statusSwitch" <? if($param["bankStatus"]=="on" ): ?>checked="checked"
													<? endif; ?> value="on"> </label>
											</div>
										</div>
										<div class="card-body p-9">
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Minimum Deposit Limit</label>
													<label class="fw-semibold text-gray-600 lh-sm">Minimum amount of deposit for transactions</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<span class="input-group-text border">₺</span>
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="bankMinDeposit" data-default="250" value="<?=$param["bankMinDeposit"] ?>" />
													</div>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Maximum Deposit Limit</label>
													<label class="fw-semibold text-gray-600 lh-sm">Maximum amount of deposit for transactions</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group">
														<span class="input-group-text border">₺</span>
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border" name="bankMaxDeposit" data-default="15000" value="<?=$param["bankMaxDeposit"] ?>" />
													</div>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Active Bank Options</label>
													<label class="fw-semibold text-gray-600 lh-sm">Bank options where accounts can be defined</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<select class="form-select form-select-solid border" data-control="select2" <?= edit_setting !== true ? "disabled" : null; ?> name="availableBanks[]" data-close-on-select="false" data-placeholder="All banks" data-allow-clear="true" multiple="multiple">
														<option></option>
														<? foreach(bankArray() as $key=>$value){ $x=explode(",",availableBanks); ?>
														<option value="<?=$key ?>" <?=(in_array($key,$x ?? []) ? "selected" : "") ?>><?=$value ?></option>
														<? } ?>
													</select>
												</div>
											</div>
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">Active Firms</label>
													<label class="fw-semibold text-gray-600 lh-sm">Firms where the bank system will be active</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<select class="form-select form-select-solid border" data-control="select2" <?= edit_setting !== true ? "disabled" : null; ?> name="bankStatusSite[]" data-close-on-select="false" data-placeholder="All firms" data-allow-clear="true" multiple="multiple">
														<option></option>
														<? $clientArray = explode(",",$param["bankStatusSite"]) ?>
														<? foreach($clientSelect as $client){ ?>
														<option value="<?=$client->id ?>" <? if(in_array($client->id,$clientArray)) echo "selected" ?>><?=$client->site_name ?></option>
														<? } ?>
													</select>
												</div>
											</div>
										</div>
										<? if(edit_setting === true): ?>
										<div class="card-footer p-5">
											<div class="d-flex flex-end">
												<button type="button" id="resetSetting" data-form-id="methods-bank-form" class="btn btn-sm btn-light rounded fs-7 w-100px me-3">Reset</button>
												<button type="button" id="updateSetting" data-form-id="methods-bank-form" class="btn btn-sm btn-light-primary rounded fs-7 w-100px">Save</button>
											</div>
										</div>
										<? endif ?>
									</div>
								</form>
							</div>
							<div class="tab-pane fade <?=view_setting!==true&&view_firm===true?"show active":null; ?>" id="settings-firms" role="tabpanel"  <?=view_firm!==true?"auth=\"false\"":null; ?>>
								<div class="card mb-5 mb-xxl-10 border">
									<div class="card-header">
										<div class="card-title justify-content-between w-100 m-0">
											<h2>Firms</h2>
											<? if(add_firm === true): ?>
											<button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#clientModalForm" data-id="0">
												<i class="bi bi-plus-circle fs-5"></i>
												New Firm
											</button>
											<? endif ?>
										</div>
									</div>
									<div class="card-body p-9">
										<div class="table-responsive">
											<table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5" id="datatableClient">
												<thead>
													<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
														<th class="min-w-30px">ID</td>
														<th class="min-w-100px">Firm Name</td>
														<th class="min-w-200px">API Key</td>
														<th class="min-w-80px">Secret Key</td>
														<th class="min-w-60px">Authorized</td>
														<th class="min-w-100px text-end">Actions</td>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="card mb-5 mb-xxl-10 border" <?=edit_setting!==true?"auth=\"false\"":null; ?>>
									<form id="ip-whitelist-form" class="form" action="javascript:" data-set="setting" method="post" enctype="multipart/form-data">
										<div class="card-header">
											<div class="card-title d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-center justify-content-md-between w-100 m-0">
												<h2 class="mb-1 mb-md-0">IP Whitelist</h2>
												<label class="fs-6 fw-semibold text-gray-600">Only IP addresses defined in this list can access the API</label>
											</div>
										</div>
										<div class="card-body p-9">
											<div class="row mb-6">
												<div class="col-xxl-4 d-flex flex-column justify-content-center mb-3 mb-xxl-0">
													<label class="col-form-label fw-semibold p-0 pb-1 fs-6">IP Addresses</label>
													<label class="fw-semibold text-gray-600 lh-sm">Addresses must be separated by commas</label>
												</div>
												<div class="col-xxl-8 d-flex flex-center">
													<div class="input-group d-flex">
														<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> class="form-control form-control-solid border rounded me-3" name="ipWhitelist" value="<?=$param["ipWhitelist"] ?>" placeholder="localhost" value="">
														<button type="button" <?= edit_setting !== true ? "disabled" : null; ?> id="updateSetting" data-form-id="ip-whitelist-form" class="btn btn-sm btn-light-primary rounded-1">Save</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="tab-pane fade" id="settings-logs" role="tabpanel"  <?=view_setting!==true?"auth=\"false\"":null; ?>>
								<div class="card mb-5 mb-xxl-10 border" style="opacity: .5; cursor: not-allowed;">
									<div class="card-header">
										<div class="card-title justify-content-between w-100 m-0">
											<h2>Event Logs <small>(not active)</small></h2>
										</div>
									</div>
									<div class="card-body p-9">
										<div class="row d-flex justify-content-between mb-5">
											<div class="d-flex align-items-center position-relative my-1 mw-250px">
												<span class="svg-icon svg-icon-1 position-absolute ms-6">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect><path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
													</svg>
												</span>
												<input type="text" <?= edit_setting !== true ? "disabled" : null; ?> data-kt-customer-table-filter="search" class="form-control form-control-solid border w-250px ps-15" placeholder="Search in logs">
											</div>
											<button type="button" class="btn btn-sm btn-light-primary mh-35px mw-175px">
												<span class="svg-icon svg-icon-3">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" d="M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z" fill="currentColor"></path><path d="M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z" fill="currentColor"></path><path opacity="0.3" d="M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z" fill="currentColor"></path>
													</svg>
												</span>
												Download Logs</button>
										</div>
										<div class="table-responsive">
											<table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5" id="kt_table_users_logs">
												<thead>
													<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
														<th class="min-w-20px">ID</td>
														<th class="min-w-50px">Event</td>
														<th class="min-w-50px">Function</td>
														<th class="min-w-250px">Event Details</td>
														<th class="min-w-100px text-end">Date</td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>5</td>
														<td class="min-w-70px">
															<div class="badge badge-light-success">Deposit</div>
														</td>
														<td>setNormalAccount</td>
														<td><span class="text-gray-600 fw-bolder">User(#45621)</span> normal hesap(#1261) ile eşleştirildi.</td>
														<td class="pe-0 text-end min-w-200px">16.09.2022 18:36:41</td>
													</tr>
													<tr>
														<td>4</td>
														<td class="min-w-70px">
															<div class="badge badge-light-success">Deposit</div>
														</td>
														<td>setNewMatch</td>
														<td><span class="text-gray-600 fw-bold">User(#45621)</span> için uygun normal hesap aranıyor.</td>
														<td class="pe-0 text-end min-w-200px">16.09.2022 18:25:18</td>
													</tr>
													<tr>
														<td>3</td>
														<td class="min-w-70px">
															<div class="badge badge-light-success">Deposit</div>
														</td>
														<td>setNewMatch</td>
														<td><span class="text-gray-600 fw-bold">User(#45621)</span> için 1 aktif hesap tarandı, eşleşme ve aylık limiti uygun hesap bulunamadı.</td>
														<td class="pe-0 text-end min-w-200px">16.09.2022 17:21:54</td>
													</tr>
													<tr>
														<td>2</td>
														<td class="min-w-70px">
															<div class="badge badge-light-warning">Withdraw</div>
														</td>
														<td>setRequestWithdraw</td>
														<td><span class="text-gray-600 fw-bold">User(#12365)</span> yeni çekim talebi iletmek istedi ve reddedildi: bekleyen işlemi var.</td>
														<td class="pe-0 text-end min-w-200px">16.09.2022 16:51:08</td>
													</tr>
													<tr>
														<td>1</td>
														<td class="min-w-70px">
															<div class="badge badge-light">API</div>
														</td>
														<td>getLimits</td>
														<td><span class="text-gray-600 fw-bold">Firma(#3)</span> getLimits talebinde bulundu ve talep cevaplandı.</td>
														<td class="pe-0 text-end min-w-200px">16.09.2022 15:56:49</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="row">
											<div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
												<div class="dataTables_length" id="kt_customers_table_length">
													<label>
														<select name="kt_customers_table_length" aria-controls="kt_customers_table" class="form-select form-select-sm form-select-solid">
															<option value="10">10</option>
															<option value="25">25</option>
															<option value="50">50</option>
														</select>
													</label>
												</div>
											</div>
											<div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
												<div class="dataTables_paginate paging_simple_numbers" id="kt_customers_table_paginate">
													<ul class="pagination">
														<li class="paginate_button page-item previous disabled" id="kt_customers_table_previous">
															<a href="#" aria-controls="kt_customers_table" data-dt-idx="0" tabindex="0" class="page-link">
																<i class="previous"></i>
															</a>
														</li>
														<li class="paginate_button page-item active">
															<a href="#" aria-controls="kt_customers_table" data-dt-idx="1" tabindex="0" class="page-link">1</a>
														</li>
														<li class="paginate_button page-item ">
															<a href="#" aria-controls="kt_customers_table" data-dt-idx="2" tabindex="0" class="page-link">2</a>
														</li>
														<li class="paginate_button page-item ">
															<a href="#" aria-controls="kt_customers_table" data-dt-idx="3" tabindex="0" class="page-link">3</a>
														</li>
														<li class="paginate_button page-item ">
															<a href="#" aria-controls="kt_customers_table" data-dt-idx="4" tabindex="0" class="page-link">4</a>
														</li>
														<li class="paginate_button page-item next" id="kt_customers_table_next">
															<a href="#" aria-controls="kt_customers_table" data-dt-idx="5" tabindex="0" class="page-link">
																<i class="next"></i>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="clientModalForm" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered mw-650px">
							<div class="modal-content">
								<div class="modal-header" id="kt_modal_create_new_firm_header">
									<h2 data-title></h2>
									<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
										<span class="svg-icon svg-icon-1">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" /><rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
											</svg>
										</span>
									</div>
								</div>
								<div class="modal-body py-10 px-lg-17">
									<div class="scroll-y me-n7 pe-7" id="kt_modal_create_new_firm_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_create_new_firm_header" data-kt-scroll-wrappers="#kt_modal_create_new_firm_scroll" data-kt-scroll-offset="300px">
										<div class="mb-5 fv-row">
											<label class="required fs-5 fw-semibold mb-2">Firm's Name</label>
											<input type="text" <?=edit_firm!==true?"disabled":null; ?> class="form-control form-control-solid border" name="site_name" />
											<input type="hidden" name="id" />
										</div>
										<div class="d-flex flex-column mb-5 fv-row">
											<label class="required fs-5 fw-semibold mb-2">API Key</label>
											<div class="d-flex flex-row">
												<input type="text" <?=edit_firm!==true?"disabled":null; ?> class="form-control form-control-solid border" placeholder="Unique API key that belongs to the firm" name="api_key" />
												<button type="button" id="generateKey" class="btn btn-light ms-3 mw-100px">Generate</button>
											</div>
										</div>
										<div class="d-flex flex-column mb-5 fv-row">
											<label class="required fs-5 fw-semibold mb-2">Is it authorized to send requests?</label>
											<select class="form-select form-select-solid border" data-control="select2" <?=edit_firm!==true?"disabled":null; ?> name="status" data-set="statusSwitch" id="modalStatus" data-set="statusSwitch" data-placeholder="Choose an option" data-hide-search="true">
												<option></option>
												<option value="on">Yes</option>
												<option value="0">No</option>
											</select>
										</div>
									</div>
								</div>
								<div class="modal-footer flex-center" <?=edit_firm!==true&&add_firm!==true?"disabled":null; ?>>
									<button type="reset" id="close-modal" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
									<button id="saveClient" class="btn btn-primary">Save</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <?php require appViewPath().'layout/_footer.php' ?>
		</div>
	</div>
</div> <?php require appViewPath().'layout/footer/footer.php' ?>

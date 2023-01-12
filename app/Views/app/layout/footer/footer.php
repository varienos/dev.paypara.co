        <div id="ajaxModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content" id="ajaxModalContent"></div>
            </div>
        </div>

		<script src="<?=baseUrl(gulpAssets().'/') ?>/js/scripts.bundle.js?v=<?=getVersion() ?>"></script>
        <script src="<?=baseUrl(gulpAssets().'/') ?>/plugins/global/plugins.bundle.js?v=<?=getVersion() ?>"></script>
        <script src="<?=activeDomain() . "/" . coreAssets() . "/js/app.js?v=" . md5(microtime()); ?>"></script>
	</body>
</html>
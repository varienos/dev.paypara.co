        <div id="ajaxModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content" id="ajaxModalContent"></div>
            </div>
        </div>

		<script src="<?=baseUrl(assetsPath().'/') ?>/js/scripts.bundle.js?v=<?=getVersion() ?>"></script>
        <script src="<?=baseUrl(assetsPath().'/') ?>/plugins/global/plugins.bundle.js?v=<?=getVersion() ?>"></script>
        <script src="<?=activeDomain() . "/" . assetsPath() . "/js/app.js?v=" . md5(microtime()); ?>"></script>
	</body>
</html>
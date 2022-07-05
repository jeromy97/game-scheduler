            </div><!-- /.card-body -->
        </div><!-- /.card -->
        
        <?php if (isset($_SESSION['msg'])) : ?>
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div
                    class="toast align-items-center text-white bg-<?= $_SESSION['msgType'] ?> border-0"
                    role="alert"
                    aria-live="assertive"
                    aria-atomic="true"
                    id="liveToast">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?php if($_SESSION['msgType'] === 'success'): ?>
                                <i class="fa-solid fa-check"></i>
                            <?php elseif($_SESSION['msgType'] === 'warning'): ?>
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            <?php elseif($_SESSION['msgType'] == 'danger'): ?>
                                <i class="fa-solid fa-circle-exclamation"></i>
                            <?php endif; ?>
                            &nbsp;<?= $_SESSION['msg'] ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            <script>
                $('#liveToast').toast('show');
            </script>
        <?php endif; ?>

    	<script type="text/javascript" src="<?= base_url('assets/js/site.js') ?>"></script>

    </body>
</html>

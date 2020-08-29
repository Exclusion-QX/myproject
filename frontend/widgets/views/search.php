<!-- Modal -->
<div class="modal fade" id="myModalSearch" tabindex="-1" role="dialog" aria-labelledby="myModalSearch">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= Html::beginForm(['/site/search']) ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= Html::input('text', 'keyword', null, []) ?>
                        <?= Html::submitButton('Search') ?>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>